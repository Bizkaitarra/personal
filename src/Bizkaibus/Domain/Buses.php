<?php

namespace App\Bizkaibus\Domain;

final class Buses
{
    private array $buses = [];

    public function add(Bus $bus) {
        $this->buses[$bus->minutes][] = $bus;
        ksort($this->buses);
    }

    public function toString(string $busSeparator) {
        $messages = [];
        foreach ($this->buses as $busesWithTheSameNumberOfMinutes) {
            foreach ($busesWithTheSameNumberOfMinutes as $bus) {
                $messages[] = $bus->__toString() . ". ";
            }
        }
        return implode($busSeparator, $messages);
    }
}