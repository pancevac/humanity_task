<?php


namespace App\Classes;


use App\Api\GenericHumanity;

class HumanityManager
{
    /**
     * @var GenericHumanity
     */
    protected $humanityApi;

    /**
     * @param GenericHumanity $humanityApi
     */
    public function __construct(GenericHumanity $humanityApi)
    {
        $this->humanityApi = $humanityApi;
    }

    /**
     * Return array with shifts objects between given time intervals.
     *
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->humanityApi->getShifts($startTime, $endTime);
    }
}