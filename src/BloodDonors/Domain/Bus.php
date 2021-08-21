<?php

namespace App\BloodDonors\Domain;

use DateTime;

class Bus
{
    private string $placeName;
    private string $direction;
    private string $cityName;
    private string $latitude;
    private string $longitude;

    private array $periods;

    public function __construct(
        string $placeName,
        string $direction,
        string $cityName,
        string $latitude,
        string $longitude,
        DateTime $startDate,
        DateTime $endDate
    )
    {
        $this->placeName = $placeName;
        $this->direction = $direction;
        $this->cityName = $cityName;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->periods[] = new Period($startDate, $endDate);
    }

    
    public function getPlaceName(): string
    {
        return $this->placeName;
    }

    
    public function getDirection(): string
    {
        return $this->direction;
    }

    
    public function getCityName(): string
    {
        return $this->cityName;
    }

    
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function addPeriod(DateTime $startDate, DateTime $endDate)
    {
        $this->periods[] = new Period($startDate, $endDate);
    }

    public function getPeriods(): array
    {
        return $this->periods;
    }

    public function hasOnlyOnePeriod(): bool
    {
        return count($this->getPeriods()) === 1;
    }




}