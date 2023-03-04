<?php

namespace App\Bizkaibus\Domain;

final class StationInfo
{
    private Buses $buses;

    public function __construct(public readonly string $stationName)
    {
        $this->buses = new Buses();
    }

    public function addBus(Bus $bus) {
        $this->buses->add($bus);
    }

    public function toString(string $busSeparator) {
        return sprintf(
            'Autobuses de la parada %s. ', $this->stationName
        ) . $this->buses->toString($busSeparator);
    }
}