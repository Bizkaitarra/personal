<?php

namespace App\Bizkaibus\Application;

use App\Bizkaibus\Domain\BusRepository;
use App\Bizkaibus\Domain\StationInfo;
use App\Bizkaibus\Domain\StopCode;

final class GetTimes
{
    public function __construct(
        private readonly BusRepository $busRepository
    )
    {
    }

    public function __invoke(StopCode $stopCode): StationInfo
    {
        return $this->busRepository->getTimes($stopCode);
    }

}