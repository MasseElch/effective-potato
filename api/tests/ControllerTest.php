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

abstract class ControllerTest extends WebTestCase
{
    const defaultUserEmail = 'jcl@masseelch.de';

    protected function createAnonymousClient()
    {
        return static::createClient();
    }

    protected function createAuthenticatedClient($email = self::defaultUserEmail)
    {
        $client = static::createClient();

        /** @var User $user */
        $user = $client->getContainer()
            ->get('doctrine')
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        $token = $client->getContainer()
            ->get('lexik_jwt_authentication.jwt_manager')
            ->create($user);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

        return $client;
    }

    protected function getUser($email = self::defaultUserEmail): User
    {
        return self::createClient()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(User::class)
            ->findOneBy(compact('email'))
        ;
    }
}