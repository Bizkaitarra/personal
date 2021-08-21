<?php


namespace App\BloodDonors\Application;


use App\BloodDonors\Domain\Place;
use App\BloodDonors\Domain\PlaceBuses;
use App\BloodDonors\Domain\Repository\BusFinderRepository;

class WhenToDonorFinder
{
    private BusFinderRepository $busFinderRepository;

    public function __construct(BusFinderRepository $busFinderRepository)
    {
        $this->busFinderRepository = $busFinderRepository;
    }

    public function __invoke(Place $place): PlaceBuses
    {
        return $this->busFinderRepository->findWhenAreTheBusesInPlace($place);
    }


}