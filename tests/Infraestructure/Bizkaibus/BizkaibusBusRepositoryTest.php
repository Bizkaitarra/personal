<?php

namespace App\Tests\Infraestructure\Bizkaibus;

use App\Bizkaibus\Infrastructure\Repository\BizkaibusBusRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BizkaibusBusRepositoryTest extends WebTestCase
{
    public function testExistingApplicationsReturnsQuestion()
    {
        $client = static::createClient();
        $repository = new BizkaibusBusRepository($client);
        $result = $repository->getTimes(276);
        $this->assertEquals(5, $result);
    }

}