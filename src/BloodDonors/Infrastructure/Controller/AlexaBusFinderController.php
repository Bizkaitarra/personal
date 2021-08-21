<?php

namespace App\BloodDonors\Infrastructure\Controller;

use App\BloodDonors\Application\AlexaBusFinder;
use App\BloodDonors\Domain\Place;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlexaBusFinderController extends AbstractController
{
    private AlexaBusFinder $alexaBusFinder;

    public function __construct(AlexaBusFinder $alexaBusFinder)
    {
        $this->alexaBusFinder = $alexaBusFinder;
    }


    public function __invoke(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(),true);
        if (!is_array($requestData) || !array_key_exists('place', $requestData)) {
            return new JsonResponse(['message'=>'You must send "place" parameter in request body'], Response::HTTP_BAD_REQUEST);
        }
        $placeInText = $requestData['place'];
        $place = new Place($placeInText);

        $message = $this->alexaBusFinder->__invoke($place);

        return new JsonResponse(['message'=>$message], Response::HTTP_OK);

    }

}