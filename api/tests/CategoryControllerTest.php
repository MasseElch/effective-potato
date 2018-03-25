<?php

namespace App\Tests;


use Cake\Chronos\Chronos;
use Symfony\Component\HttpFoundation\Response;

class CategoryControllerTest extends ControllerTest
{
    public function testCategoryBudgetUpdate()
    {
        $client = static::createAuthenticatedClient();

        // Current date
        $date = Chronos::now();

        $client->request(
            'patch',
            implode('/', ['/api/categories/1', $date->year, $date->month])
        );

        self::assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            $client->getResponse()->getContent()
        );
//        $this->assertSame(200, $client->getResponse()->getStatusCode());
//        $this->assertSame(1, $crawler->filter('h1:contains("Hello World")')->count());
    }
}
