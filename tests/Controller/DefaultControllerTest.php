<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $client->request('GET', '/');

        static::assertSame(200, $client->getResponse()->getStatusCode());
    }
}
