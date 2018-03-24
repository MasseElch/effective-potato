<?php

namespace App\Tests;


class CategoryControllerTest extends ControllerTest
{
    public function testCategoryBudgetUpdate()
    {
        $client = static::createAuthenticatedClient();

        $client->request('PUT', '/');

//        $this->assertSame(200, $client->getResponse()->getStatusCode());
//        $this->assertSame(1, $crawler->filter('h1:contains("Hello World")')->count());
    }
}
