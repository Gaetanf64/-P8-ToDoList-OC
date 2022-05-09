<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginSuccess()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        static::assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton("Se connecter")->form([
            "_username" => "TestUsername",
            "_password" => 'Test64'
        ]);

        $client->submit($form);
        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode());

        //$this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        //$client->followRedirect();

        //$this->assertRouteSame('index');

        //Pour utiliser $client dans d'autres méthodes
        return $client;
    }

    public function testLoginFailed()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        static::assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton("Se connecter")->form([
            "_username" => "TestUsername",
            "_password" => 'test'
        ]);

        $client->submit($form);
        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode());
    }
}
