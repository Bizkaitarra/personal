<?php

namespace App\BloodDonors\Domain;

use DateTime;

class Period
{
    private DateTime $startDate;
    private DateTime $endDate;

    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function isMorning(): bool
    {
        return 'AM' === $this->startDate->format('A');
    }

    public function getDayNumber():string {
        return $this->startDate->format('j');
    }

    public function getStartHour():string {
        return $this->startDate->format('g');
    }

    public function getEndtHour():string {
        return $this->endDate->format('g');
    }



}