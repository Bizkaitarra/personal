<?php

namespace App\SchoolMenu\Infrastructure\Controller;

use App\SchoolMenu\Application\AlexaNextMenuFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AlexaNextMenuFinderController extends AbstractController
{
    private AlexaNextMenuFinder $alexaNextMenuFinder;

    public function __construct(AlexaNextMenuFinder $alexaNextMenuFinder)
    {
        $this->alexaNextMenuFinder = $alexaNextMenuFinder;
    }


    public function __invoke()
    {
        $message = $this->alexaNextMenuFinder->__invoke();
        return new JsonResponse(['message'=>$message], Response::HTTP_OK);
    }

}