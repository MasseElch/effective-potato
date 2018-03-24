<?php
/**
 * Created by PhpStorm.
 * User: jcl
 * Date: 19.03.18
 * Time: 10:29
 */

namespace App\Tests;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    protected function createAnonymousClient()
    {
        return static::createClient();
    }

    protected function createAuthenticatedClient($email = 'testuser@mail.com')
    {
        $client = static::createClient();

        /** @var User $user */
        $user = $client->getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['email' => $email]);

        $token = $client->getContainer()->get('lexik_jwt_authentication.jwt_manager')->create($user);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }

}