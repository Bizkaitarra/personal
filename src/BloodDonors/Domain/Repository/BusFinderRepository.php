<?php


namespace App\BloodDonors\Domain\Repository;


use App\BloodDonors\Domain\Place;
use App\BloodDonors\Domain\PlaceBuses;

interface BusFinderRepository
{
    public function findWhenAreTheBusesInPlace(Place $place): PlaceBuses;
}