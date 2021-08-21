<?php

namespace App\Tests\BloodDonors\Infrastructure;

use App\BloodDonors\Domain\Bus;
use App\BloodDonors\Domain\Place;
use App\BloodDonors\Infrastructure\Repository\ApiBusFinderRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;


class ApiBusFinderRepositoryTest extends WebTestCase
{
    //Must be blank before commit
    private $apiURL = '';
    public function testWhenAreTheBusesInBasauri() {
        $place = new Place('Basauri');
        $client = HttpClient::create();
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $parameterBag->method('get')->willReturn($this->apiURL);
        $busFinder = new ApiBusFinderRepository(
            $parameterBag,
            $client
        );
        $response = $busFinder->findWhenAreTheBusesInPlace($place);
        $this->assertEquals($place->getValue(), $response->getPlace()->getValue());
        foreach ($response->getBuses() as $bus) {
            $this->assertInstanceOf(Bus::class, $bus);
        }
    }
    public function testWhenAreTheBusesInBilbao() {
        $place = new Place('Bilbao');
        $client = HttpClient::create();
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $parameterBag->method('get')->willReturn($this->apiURL);
        $busFinder = new ApiBusFinderRepository(
            $parameterBag,
            $client
        );
        $response = $busFinder->findWhenAreTheBusesInPlace($place);
        $this->assertEquals($place->getValue(), $response->getPlace()->getValue());
        foreach ($response->getBuses() as $bus) {
            $this->assertInstanceOf(Bus::class, $bus);
        }
    }
}