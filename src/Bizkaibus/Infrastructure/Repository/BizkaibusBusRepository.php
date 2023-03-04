<?php

namespace App\Bizkaibus\Infrastructure\Repository;

use App\Bizkaibus\Domain\Bus;
use App\Bizkaibus\Domain\BusRepository;
use App\Bizkaibus\Domain\StationInfo;
use App\Bizkaibus\Domain\StopCode;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class BizkaibusBusRepository implements BusRepository
{
    public function __construct(
        private readonly HttpClientInterface $httpClient
    )
    {
    }

    private const BIZKAIBUS_URL = 'http://apli.bizkaia.net/APPS/DANOK/TQWS/TQ.ASMX/GetPasoParadaMobile_JSON?callback=%22%22&strLinea=&strParada=';

    public function getTimes(StopCode $stopCode): StationInfo
    {
        $data = $this->getBizkaibusResponseWithWget($stopCode);
        $data = str_replace('""(', '', $data);
        $data = str_replace(');', '', $data);
        $data = str_replace("'", '"', $data);
        $decodedData = json_decode($data, true);
        $xml = $decodedData['Resultado'];
        $result = $this->xmlToArray($xml);
        $stopName = $result['DenominacionParada'];
        $stationInfo = new StationInfo($stopName);
        foreach ($result['PasoParada'] as $line) {
            $currentElementIndex = 1;
            $elementIndex =  'e'.$currentElementIndex;
            while (array_key_exists($elementIndex, $line)) {

                $bus = $line[$elementIndex];
                $stationInfo->addBus(
                    new Bus(
                        $line['linea'],
                        $line['ruta'],
                        $this->convertMinutes($bus['minutos']),
                    )
                );
                $currentElementIndex++;
                $elementIndex = 'e'.$currentElementIndex;
            }
        }
        return $stationInfo;
    }

    private function getBizkaibusResponse(StopCode $stopCode): string {
        $response = $this->httpClient->request('GET', self::BIZKAIBUS_URL . $stopCode->value);
        return $response->getContent();
    }

    private function getBizkaibusResponseWithWget(StopCode $stopCode): string {
        return file_get_contents( self::BIZKAIBUS_URL . $stopCode->value);
    }

    private function print($data, string $name) {
        echo "<h2>$name</h2>";
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    private function xmlToArray(string $xml) {
        return json_decode(json_encode(simplexml_load_string($xml)),true);
    }

    private function convertMinutes($minutes) {
        if (!is_numeric($minutes)) {
            return 0;
        }
        return $minutes;
    }
}