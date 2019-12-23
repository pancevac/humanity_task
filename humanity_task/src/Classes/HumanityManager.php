<?php


namespace App\Classes;


use App\Interfaces\HumanityApiInterface;

class HumanityManager
{
    protected $humanityApi;

    public function __construct(HumanityApiInterface $humanityApi)
    {
        $this->humanityApi = $humanityApi;
    }

    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        return $this->humanityApi->getShifts($startTime, $endTime);
    }
}