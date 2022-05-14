<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccessAsAdmin();

        $crawler = $client->request('GET', '/users');
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSame("Liste des utilisateurs", $crawler->filter('h1')->text());
    }

    public function testEditAction(): void
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccessAsAdmin();

        $crawler = $client->request('GET', '/users/8/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        //Test si les champs existent
        static::assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[email]"]')->count());
        static::assertSame(2, $crawler->filter('input[name="user[roles][]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'testUser';
        $form['user[password][first]'] = 'Test64';
        $form['user[password][second]'] = 'Test64';
        $form['user[email]'] = 'test@gmail.com';
        $form['user[roles][0]']->tick();

        $client->submit($form);


        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSelectorTextContains('h1', "Liste des utilisateurs");
    }

    public function testCreateAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccessAsAdmin();

        $crawler = $client->request('GET', '/users/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        //Test si les champs existent
        static::assertSame(1, $crawler->filter('input[name="user[username]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][first]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[password][second]"]')->count());
        static::assertSame(1, $crawler->filter('input[name="user[email]"]')->count());
        static::assertSame(2, $crawler->filter('input[name="user[roles][]"]')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'newUser2';
        $form['user[password][first]'] = 'testAdd';
        $form['user[password][second]'] = 'testAdd';
        $form['user[email]'] = 'newUser2@gmail.com';
        $form['user[roles][0]']->tick();

        $client->submit($form);

        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSelectorTextContains('h1', "Liste des utilisateurs");
    }
}
