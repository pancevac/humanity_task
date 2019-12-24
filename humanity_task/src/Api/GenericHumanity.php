<?php


namespace App\Api;


use App\Entities\Shift;

abstract class GenericHumanity
{
    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var array
     */
    protected $shifts = [];

    /**
     * Create and return new shift object with data.
     *
     * @param $shiftData
     * @return Shift
     */
    abstract protected function createShift($shiftData): Shift;

    /**
     * Call lifecycle method to signal child class for calling requests...
     *
     * @return void
     */
    abstract protected function sendRequests(): void;

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
        $this->startDate = $startTime;
        $this->endDate = $endTime;

        $this->sendRequests();

        // This will ensure that returning array is filled with Shift objects...
        return array_map(function ($shift) {
            return $this->createShift($shift);
        }, $this->shifts);
    }
}