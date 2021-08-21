<?php


namespace App\BloodDonors\Infrastructure\Repository;

use App\BloodDonors\Domain\Exception\ApiException;
use App\BloodDonors\Domain\Place;
use App\BloodDonors\Domain\PlaceBuses;
use App\BloodDonors\Domain\Repository\BusFinderRepository;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiBusFinderRepository implements BusFinderRepository
{

    private $endpointUrl;
    private HttpClientInterface $client;

    public function __construct(
        ParameterBagInterface $parameterBag,
        HttpClientInterface $client
    )
    {
        $this->endpointUrl = $parameterBag->get('BLOOD_DONORS_BY_PLACE_WS_URL');
        $this->client = $client;
    }


    /**
     * @throws ApiException
     */
    public function findWhenAreTheBusesInPlace(Place $place): PlaceBuses
    {
        $startDate = date('Y/m/d');
        $endDate = '2030/12/31';

        $endpoint = sprintf(
            '%s?localidad=%s&fechaInicio=%s&fechaFinal=%s',
            $this->endpointUrl,
            $place->getValue(),
            $startDate,
            $endDate
        );

        try {
            $response = $this->client->request('GET', $endpoint);
            $responseData = $response->toArray();


        } catch (TransportExceptionInterface |
                ClientExceptionInterface |
                DecodingExceptionInterface |
                RedirectionExceptionInterface |
                ServerExceptionInterface $e) {
            throw new ApiException();
        }

        $placeBuses = new PlaceBuses($place);

        foreach ($responseData as $busData) {
            $startDate = DateTime::createFromFormat('Y-m-d H:i:s',$busData['horaInicio']);
            $endDate = DateTime::createFromFormat('Y-m-d H:i:s',$busData['horaFin']);

            $placeBuses->addBus(
                $busData['nombre'],
                $busData['direccion'],
                $busData['localidad'],
                $busData['latitud'],
                $busData['longitud'],
                $startDate,
                $endDate
            );
        }

        return $placeBuses;


    }
}