<?php

namespace App\BloodDonors\Domain;

use DateTime;

class PlaceBuses
{
    private Place $place;
    private array $buses = [];

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    public function addBus(
        string $placeName,
        string $direction,
        string $cityName,
        string $latitude,
        string $longitude,
        DateTime $startDate,
        DateTime $endDate
    ) {
        if (array_key_exists($placeName, $this->buses) && $this->buses[$placeName] instanceof Bus) {
            $this->buses[$placeName]->addPeriod($startDate, $endDate);
            return;
        }
        $bus= new Bus(
            $placeName,
            $direction,
            $cityName,
            $latitude,
            $longitude,
            $startDate,
            $endDate
        );
        $this->buses[$placeName] = $bus;
    }



    public function getPlace(): Place
    {
        return $this->place;
    }

    public function getBuses(): array
    {
        return $this->buses;
    }

    public function hasBuses():bool {
        return count($this->buses)>0;
    }




}