<?php


namespace App\Classes;


use App\Api\GenericHumanity;

class HumanityManager
{
    protected $humanityApi;

    public function __construct(GenericHumanity $humanityApi)
    {
        $this->humanityApi = $humanityApi;
    }

    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->humanityApi->getShifts($startTime, $endTime);
    }
}