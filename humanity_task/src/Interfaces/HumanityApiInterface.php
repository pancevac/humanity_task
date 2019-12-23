<?php


namespace App\Interfaces;


interface HumanityApiInterface
{
    /**
     * Return list of shifts entity objects with
     * its related timeClock and employee objects.
     *
     * @param \DateTime $startTime
     * @param \DateTime $endTime
     * @return array
     */
    public function getShifts(\DateTime $startTime, \DateTime $endTime): array ;
}