<?php

namespace App\Bizkaibus\Domain;

interface BusRepository
{
    public function getTimes(StopCode $stopCode): StationInfo;
}