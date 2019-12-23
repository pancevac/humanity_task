<?php


namespace App\Entities;


class TimeClock
{
    protected $inTime;
    protected $outTime;

    /**
     * @param \DateTime|null $inTime
     * @param \DateTime|null $outTime
     */
    public function __construct(\DateTime $inTime = null, \DateTime $outTime = null)
    {
        $this->inTime = $inTime;
        $this->outTime = $outTime;
    }

    /**
     * @return string
     */
    public function getInTime(): string
    {
        return $this->inTime->format('H:i');
    }

    /**
     * @return string
     */
    public function getOutTime(): string
    {
        return $this->outTime->format('H:i');
    }


}