<?php


namespace App\Classes;


use App\Entities\Employee;
use App\Entities\Shift;
use App\Entities\TimeClock;
use App\Interfaces\HumanityApiInterface;
use App\Libraries\ShiftPlaning;

class HumanityApiV1 implements HumanityApiInterface
{
    private $planingShifts;

    public function __construct()
    {
        $this->planingShifts = new ShiftPlaning([
            'key' => getenv('API_KEY'),
        ]);
    }

    /**
     * Return list of shifts entity objects with
     * its related timeClock and employee objects.
     *
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        $response = $this->requestShifts($startTime, $endTime);

        if (!is_array($response['data']) || !$response['data']) {
            return [];
        }

        $timeClocks = $this->requestClockTimes($startTime, $endTime);

        return array_map(function (array $shift) use ($timeClocks) {

            $relatedTimeClock = $this->findRelatedTimeClock($shift, $timeClocks);

            return new Shift(
                $shift['id'],
                new \DateTime($shift['start_date']['date']),
                new \DateTime($shift['end_date']['date']),
                $shift['schedule_name'],
                new Employee($shift['employees'][0]['id'], $shift['employees'][0]['name']),
                $relatedTimeClock ? new TimeClock(
                    new \DateTime($relatedTimeClock['start_timestamp']),
                    new \DateTime($relatedTimeClock['end_timestamp'])
                ) : null
            );
        }, $response['data']);
    }

    /**
     * Send request to API for shifts.
     *
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    protected function requestShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->planingShifts->setRequest([
            'module' => 'schedule.shifts',
            'method' => 'GET',
            'mode' => 'overview',
            'start_date' => $startTime->format('Y-m-d H:i:s'),
            'end_date' => $endTime->format('Y-m-d H:i:s'),
            'token' => getenv('API_TOKEN'),
        ]);
    }

    /**
     * Send request for clockTimes for given time interval.
     * Instead of sending one request for every employee,
     * we can optimize code by sending single request for given time.
     *
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    protected function requestClockTimes(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->planingShifts->setRequest([
            'module' => 'timeclock.timeclocks',
            'method' => 'GET',
            'start_date' => $startTime->format('Y-m-d'),
            'end_date' => $endTime->format('Y-m-d'),
            'token' => getenv('API_TOKEN'),
        ]);
    }

    /**
     * Send request for clockTimes for given time interval and employee ID.
     * This is less efficient than method "requestClockTimes" because it makes
     * single request for employee.
     *
     * @param int $employeeId
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    protected function requestClockTime(int $employeeId, \DateTime $startTime, \DateTime $endTime): array
    {
        return $this->planingShifts->setRequest([
            'module' => 'timeclock.timeclocks',
            'method' => 'GET',
            'employee_id' => $employeeId,
            'start_date' => $startTime->format('Y-m-d'),
            'end_date' => $endTime->format('Y-m-d'),
            'token' => getenv('API_TOKEN'),
        ]);
    }

    /**
     * @param $shift
     * @param $timeClocks
     */
    protected function findRelatedTimeClock($shift, $timeClocks)
    {
        if (empty($timeClocks) || !isset($timeClocks['data']) || !$timeClocks['data']) return;

        foreach ($timeClocks['data'] as $timeClock) {
            if ($shift['id'] == $timeClock['shift']) {
                return $timeClock;
            }
        }

        return;
    }
}