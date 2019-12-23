<?php


namespace App\Classes;


use App\Interfaces\HumanityApiInterface;

class HumanityApiV2 implements HumanityApiInterface
{
    /**
     * @inheritDoc
     */
    public function getShifts(\DateTime $startTime, \DateTime $endTime): array
    {
        // TODO: Implement getShifts() method.
    }
}