<?php

namespace App\SchoolMenu\Domain;

use App\Entity\DayMenu;
use DateTimeInterface;

class AlexaMenuDay
{
    private DateTimeInterface $day;
    private string $first;
    private string $second;
    private string $dessert;

    private function __construct(DateTimeInterface $day, string $first, string $second, string $dessert)
    {
        $this->day = $day;
        $this->first = $first;
        $this->second = $second;
        $this->dessert = $dessert;
    }

    public static function fromDayMenu(DayMenu $dayMenu) {
        return new self(
            $dayMenu->getDay(),
            $dayMenu->getFirst(),
            $dayMenu->getSecond(),
            $dayMenu->getDessert()
        );
    }

    public function getMessage(): string
    {
        $weekDayName = $this->getDayNameFromNumber();
        $monthDayNumber = $this->getMonthDayNumber();
        return sprintf(
            ' El %s día %s tienen de primero %s. De segundo %s. De postre tienen %s. ',
            $weekDayName,
            $monthDayNumber,
            $this->first,
            $this->second,
            $this->dessert
        );
    }

    private function getDayNameFromNumber() {
        $weekDayNumber = $this->day->format('N');

        switch ($weekDayNumber) {
            case 1:
                return 'lunes';
            case 2:
                return 'martes';
            case 3:
                return 'miércoles';
            case 4:
                return 'jueves';
            case 5:
                return 'viernes';
            case 6:
                return 'sábado';
            case 7:
                return 'domingo';
        }
        return '';
    }

    private function getMonthDayNumber(): string
    {
        return $this->day->format('j');
    }


}