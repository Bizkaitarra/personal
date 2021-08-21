<?php

namespace App\Tests\BloodDonors\Application;

use App\BloodDonors\Application\AlexaBusFinder;
use App\BloodDonors\Domain\Place;
use App\BloodDonors\Domain\PlaceBuses;
use App\BloodDonors\Domain\Repository\BusFinderRepository;
use DateTime;
use PHPUnit\Framework\TestCase;

class AlexaBusFinderTest extends TestCase
{
    public function testEmptyBusesMessage() {
        $busFinderRepository = $this->createMock(BusFinderRepository::class);
        $place = new Place('Basauri');
        $busPlaces = new PlaceBuses($place);
        $busFinderRepository->method('findWhenAreTheBusesInPlace')->willReturn($busPlaces);
        $alexaBusFinder = new AlexaBusFinder(
            $busFinderRepository
        );
        $message = $alexaBusFinder->__invoke($place);
        $this->assertEquals(sprintf('No tengo datos para %s o no habrá autobús en pŕoximas fechas para esa localidad.', $place->getValue()), $message);
    }
    public function testOneBusAndOnePeriodMessage() {
        $busFinderRepository = $this->createMock(BusFinderRepository::class);
        $place = new Place('Basauri');
        $busPlaces = new PlaceBuses($place);
        $busPlaces->addBus(
            'Plaza del pueblo',
            'Akilino Arriola 3',
            'Basauri',
            '',
            '',
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 10:00'),
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 14:00')
        );
        $busFinderRepository->method('findWhenAreTheBusesInPlace')->willReturn($busPlaces);
        $alexaBusFinder = new AlexaBusFinder(
            $busFinderRepository
        );
        $message = $alexaBusFinder->__invoke($place);
        $this->assertNotEquals(sprintf('No tengo datos para %s o no habrá autobús en pŕoximas fechas para esa localidad.', $place->getValue()), $message);
        $this->assertStringContainsStringIgnoringCase('El autobús estará en 1 lugares distintos', $message);
    }
    public function testOneBusAndTwoPeriodsMessage() {
        $busFinderRepository = $this->createMock(BusFinderRepository::class);
        $place = new Place('Basauri');
        $busPlaces = new PlaceBuses($place);
        $busPlaces->addBus(
            'Plaza del pueblo',
            'Akilino Arriola 3',
            'Basauri',
            '',
            '',
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 10:00'),
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 14:00')
        );
        $busPlaces->addBus(
            'Plaza del pueblo',
            'Akilino Arriola 3',
            'Basauri',
            '',
            '',
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-23 15:00'),
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-23 20:00')
        );
        $busFinderRepository->method('findWhenAreTheBusesInPlace')->willReturn($busPlaces);
        $alexaBusFinder = new AlexaBusFinder(
            $busFinderRepository
        );
        $message = $alexaBusFinder->__invoke($place);
        $this->assertNotEquals(sprintf('No tengo datos para %s o no habrá autobús en pŕoximas fechas para esa localidad.', $place->getValue()), $message);
        $this->assertStringContainsStringIgnoringCase('El autobús estará en 1 lugares distintos', $message);
        $this->assertStringContainsStringIgnoringCase('el día 21 de 10 de la mañana a 2', $message);
        $this->assertStringContainsStringIgnoringCase('el día 23 de 3 de la tarde a 8', $message);
    }
    public function testTwoBusesAndOnePeriodMessage() {
        $busFinderRepository = $this->createMock(BusFinderRepository::class);
        $place = new Place('Basauri');
        $busPlaces = new PlaceBuses($place);
        $busPlaces->addBus(
            'Plaza del pueblo',
            'Akilino Arriola 3',
            'Basauri',
            '',
            '',
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 10:00'),
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-21 14:00')
        );
        $busPlaces->addBus(
            'Ambulatorio',
            'Akilino Arriola 3',
            'Basauri',
            '',
            '',
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-23 15:00'),
            DateTime::createFromFormat('Y-m-d H:i', '2021-08-23 20:00')
        );
        $busFinderRepository->method('findWhenAreTheBusesInPlace')->willReturn($busPlaces);
        $alexaBusFinder = new AlexaBusFinder(
            $busFinderRepository
        );
        $message = $alexaBusFinder->__invoke($place);
        $this->assertNotEquals(sprintf('No tengo datos para %s o no habrá autobús en pŕoximas fechas para esa localidad.', $place->getValue()), $message);
        $this->assertStringContainsStringIgnoringCase('El autobús estará en 2 lugares distintos', $message);
        $this->assertStringContainsStringIgnoringCase('el día 21 de 10 de la mañana a 2', $message);
        $this->assertStringContainsStringIgnoringCase('el día 23 de 3 de la tarde a 8', $message);
    }
}