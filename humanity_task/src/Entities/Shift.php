<?php


namespace App\Entities;


class Shift
{
    protected $id;
    protected $startDate;
    protected $endDate;
    protected $position;
    protected $employee;
    protected $timeClock;

    /**
     * @param int $id
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $position
     * @param Employee $employee
     * @param TimeClock|null $timeClock
     */
    public function __construct(int $id,
                                \DateTime $startDate,
                                \DateTime $endDate,
                                string $position,
                                Employee $employee,
                                TimeClock $timeClock = null)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->position = $position;
        $this->employee = $employee;
        $this->timeClock = $timeClock;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): string
    {
        return $this->startDate->format('H:i');
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): string
    {
        return $this->endDate->format('H:i');
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @return TimeClock|null
     */
    public function getTimeClock(): ?TimeClock
    {
        return $this->timeClock;
    }




}