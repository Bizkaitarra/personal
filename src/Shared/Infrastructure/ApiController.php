<?php


namespace App\Shared\Infrastructure;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiController extends AbstractController
{
    protected function returnException(\Exception $exception) {
        return new JsonResponse(['message'=> $exception->getMessage()],$exception->getCode());
    }

    public function serializeResponse($httpCode, $data)
    {
        $defaultContext = [
        ];

        $encoder = new JsonEncoder();

        $normalizer = new GetSetMethodNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            null,
            null,
            $defaultContext
        );

        $serializer = new Serializer([$normalizer], [$encoder]);

        $data = $serializer->serialize($data, 'json');

        return new JsonResponse(
            $data,
            $httpCode,
            [],
            true
        );
    }
}