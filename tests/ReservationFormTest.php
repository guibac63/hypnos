<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationFormTest extends WebTestCase
{
    public function testSubmitPossibilityReservationForm(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('guibac63@hotmail.fr');
        // test e.g. the profile page
        $crawler = $client->request('GET', '/reservation');
        //submission reservation form button doesn't exists for visitor
        $this->assertCount(0,$crawler->filter("button"));
        // simulate subscriber being logged in
        $client->loginUser($testUser);
        // test e.g. the profile page
        $crawler = $client->request('GET', '/reservation');
        $this->assertResponseIsSuccessful();
        //submission reservation form appears for subscriber
        $this->assertCount(1,$crawler->filter("button"));
    }
}
