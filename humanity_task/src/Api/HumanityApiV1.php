<?php


namespace App\Api;


use App\Entities\Employee;
use App\Entities\Shift;
use App\Entities\TimeClock;
use App\Libraries\ShiftPlaning;

class HumanityApiV1 extends GenericHumanity
{
    /**
     * @var ShiftPlaning
     */
    private $planingShifts;

    /**
     * @var array
     */
    private $timeClocks = [];

    public function __construct()
    {
        $this->planingShifts = new ShiftPlaning([
            'key' => getenv('API_KEY'),
        ]);

        $this->InitSession();
    }

    /**
     * Call lifecycle method to signal child class for calling requests...
     *
     * @return void
     * @throws \Exception
     */
    protected function sendRequests(): void
    {
        $response = $this->requestShifts();

        if (is_array($response['data']) || $response['data']) {
            $this->shifts = $response['data'];
            $this->timeClocks = $this->requestClockTimes();
        }
    }

    /**
     * Create and return new shift object with data.
     *
     * @param $shiftData
     * @return Shift
     * @throws \Exception
     */
    protected function createShift($shiftData): Shift
    {
        $relatedTimeClock = $this->findRelatedTimeClock($shiftData);

        return new Shift(
            $shiftData['id'],
            new \DateTime($shiftData['start_date']['date']),
            new \DateTime($shiftData['end_date']['date']),
            $shiftData['schedule_name'],
            new Employee($shiftData['employees'][0]['id'], $shiftData['employees'][0]['name']),
            $relatedTimeClock ? new TimeClock(
                new \DateTime($relatedTimeClock['start_timestamp']),
                new \DateTime($relatedTimeClock['end_timestamp'])
            ) : null
        );
    }

    /**
     * Send request to API for shifts.
     *
     * @return array
     */
    protected function requestShifts(): array
    {
        return $this->planingShifts->setRequest([
            'module' => 'schedule.shifts',
            'method' => 'GET',
            'mode' => 'overview',
            'start_date' => $this->startDate->format('Y-m-d H:i:s'),
            'end_date' => $this->endDate->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Send request for clockTimes for given time interval.
     * Instead of sending one request for every employee,
     * we can optimize code by sending single request for given time.
     *
     * @return array
     */
    protected function requestClockTimes(): array
    {
        return $this->planingShifts->setRequest([
            'module' => 'timeclock.timeclocks',
            'method' => 'GET',
            'start_date' => $this->startDate->format('Y-m-d H:i:s'),
            'end_date' => $this->endDate->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @param $shift
     * @return mixed|void
     */
    protected function findRelatedTimeClock($shift)
    {
        $timeClocks = $this->timeClocks;

        if (empty($timeClocks) || !isset($timeClocks['data']) || !$timeClocks['data']) return;

        foreach ($timeClocks['data'] as $timeClock) {
            if ($shift['id'] == $timeClock['shift']) {
                return $timeClock;
            }
        }

        return;
    }

    /**
     * Init session, check if exist, otherwise do login...
     *
     * @return void
     */
    private function InitSession(): void
    {
        // Check session
        if (!$this->planingShifts->getSession()) {
            $response = $this->planingShifts->doLogin([
                'username' => getenv('API_USERNAME'),
                'password' => getenv('API_PASSWORD')
            ]);

            if ($response['status']['code'] != 1) {
                // display the login error to the user
                echo $response['status']['text'] . "--" . $response['status']['error'];
            }
        }
    }
}