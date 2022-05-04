<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessRoutesTest extends WebTestCase
{
    public function testHomeAccessNonConnected(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
