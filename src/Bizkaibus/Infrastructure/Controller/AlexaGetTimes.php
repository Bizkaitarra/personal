<?php

namespace App\Bizkaibus\Infrastructure\Controller;

use App\Bizkaibus\Application\GetTimes;
use App\Bizkaibus\Domain\StopCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AlexaGetTimes extends AbstractController
{
    public function __invoke(
        GetTimes $getTimes,
        string $stopCode
    )
    {
        $stopCode = new StopCode($stopCode);
        try {
            $stationInfo = $getTimes->__invoke($stopCode);
            return new Response($stationInfo->toString("\n"));
        } catch (\Exception $exception) {
            return new Response('No se han encontrado datos para la parada solicitada');
        }
    }

}