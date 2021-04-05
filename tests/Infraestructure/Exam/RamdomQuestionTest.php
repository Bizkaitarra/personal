<?php


namespace App\Tests\Infraestructure\Exam;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RamdomQuestionTest extends WebTestCase
{
    private const EXISTING_APPLICATION_IDS = [
      1,2,3
    ];
    private const NOT_EXISTING_APPLICATION_ID = 4;

    public function testExistingApplicationsReturnsQuestion()
    {
        $client = static::createClient();

        foreach (self::EXISTING_APPLICATION_IDS as $applicationId) {
            $client->request('GET', '/exam/ramdon-question/'.$applicationId);
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }
    }
    public function testNotExistingApplicationReturnsBadRequest()
    {
        $client = static::createClient();

        $client->request('GET', '/exam/ramdon-question/'.self::NOT_EXISTING_APPLICATION_ID);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

}