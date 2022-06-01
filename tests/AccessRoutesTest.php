<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccessRoutesTest extends WebTestCase
{
    /**
     * @dataProvider accessNonConnectedProvider
     */
    public function testAccessNonConnected($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);
        $client->catchExceptions(false);
        self::assertSame(200,$client->getResponse()->getStatusCode());
    }

    public function accessNonConnectedProvider():array
    {
        return [
            ['/'],
            ['/etablissements'],
            ['/etablissement/4'],
            ['/reservation'],
            ['/contact'],
            ['/login'],
            ['/mentions'],
            ['/reset-password'],
            ['/register'],
        ];
    }

    /**
     * @dataProvider redirectForbiddenAccessProvider
     */
    public function testRedirectForbiddenAccess($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);
        $client->catchExceptions(false);
        self::assertSame(302,$client->getResponse()->getStatusCode());
    }

    public function redirectForbiddenAccessProvider():array
    {
        return [
            ['/admin'],
            ['/manager'],
            ['/monespace']
        ];
    }

    /**
     * @dataProvider protectedRouteProvider
     */
    public function testProtectedRoute($url,$mail)
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail($mail);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', $url);

        self::assertSame(403,$client->getResponse()->getStatusCode());
    }
    public function protectedRouteProvider():array
    {
        return [
            ['/admin','guibac63@hotmail.fr'],
            ['/admin','mich.tourraine@gmail.com'],
            ['/manager','RichLion@gmail.com'],
            ['/manager','guibac63@hotmail.fr'],
            ['/monespace','RichLion@gmail.com'],
            ['/monespace','mich.tourraine@gmail.com'],
            ];
    }






}
