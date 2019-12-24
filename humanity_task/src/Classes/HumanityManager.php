<?php


namespace App\Classes;


use App\Api\AbstractHumanity;

class HumanityManager
{
    protected $humanityApi;

    public function __construct(AbstractHumanity $humanityApi)
    {
        $this->humanityApi = $humanityApi;
    }

    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->humanityApi->getShifts($startTime, $endTime);
    }
}