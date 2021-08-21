<?php


namespace App\BloodDonors\Application;


use App\BloodDonors\Domain\Bus;
use App\BloodDonors\Domain\Period;
use App\BloodDonors\Domain\Place;
use App\BloodDonors\Domain\PlaceBuses;
use App\BloodDonors\Domain\Repository\BusFinderRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AlexaBusFinder
{
    private const MAX_BUSES_TO_RESPONSE = 5;
    private BusFinderRepository $busFinderRepository;

    public function __construct(BusFinderRepository $busFinderRepository)
    {
        $this->busFinderRepository = $busFinderRepository;
    }

    public function __invoke(Place $place): string
    {

        $placeBuses = $this->busFinderRepository->findWhenAreTheBusesInPlace($place);

        if (!$placeBuses->hasBuses()) {
            return sprintf('No tengo datos para %s o no habrá autobús en pŕoximas fechas para esa localidad.', $place->getValue());

        }
        $i = 0;
        $message = sprintf('El autobús estará en %s lugares distintos. ', count($placeBuses->getBuses()));
        foreach ($placeBuses->getBuses() as $bus) {

            if ($i > self::MAX_BUSES_TO_RESPONSE) {
                return $message;
            }
            $i++;
            $message .= $this->getBusMessage($bus);
        }
        return $message;

    }

    private function getBusMessage(Bus $bus):string {
        $message = '';
        $first = true;
        foreach ($bus->getPeriods() as $period) {
            if ($first) {
                $message .= sprintf(
                    ' En %s con dirección %s %s. ',
                    $bus->getCityName(),
                    $bus->getDirection(),
                    $this->getPeriodMessage($period));
                $first = false;
            } else {
                $message .= sprintf(
                    ' También %s. ',
                    $this->getPeriodMessage($period));
            }

        }
        return $message;
    }
    private function getPeriodMessage(Period $period) {
        if ($period->isMorning()) {
            return sprintf(' el día %s de %s de la mañana a %s', $period->getDayNumber(), $period->getStartHour(), $period->getEndtHour());
        }
        return sprintf(' el día %s de %s de la tarde a %s', $period->getDayNumber(), $period->getStartHour(), $period->getEndtHour());
    }


}