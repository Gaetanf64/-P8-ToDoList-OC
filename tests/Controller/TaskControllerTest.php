<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    public function testListActionWithoutLogin()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());


        static::assertSame(1, $crawler->filter('input[name="_username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="_password"]')->count());
    }

    public function testListActionWithLogin()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $client->request('GET', '/tasks');
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $crawler = $client->request('GET', '/tasks/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());


        static::assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        static::assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'new Task';
        $form['task[content]'] = 'content Test Task';
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testEditAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $crawler = $client->request('GET', '/tasks/1/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame(1, $crawler->filter('input[name="task[title]"]')->count());
        static::assertSame(1, $crawler->filter('textarea[name="task[content]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'edit Task';
        $form['task[content]'] = 'content Edit Task test';
        $client->submit($form);
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testToggleTaskAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $client->request('GET', '/tasks/1/toggle');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }


    public function testDeleteTaskActionAuthor()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $crawler = $client->request('GET', '/tasks/32/delete');

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        static::assertSame("Superbe ! La tâche a bien été supprimée.", $crawler->filter('div.alert.alert-success')->text());
    }

    public function testDeleteTaskActionAuthorError()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $crawler = $client->request('GET', '/tasks/33/delete');

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame("Oops ! Vous n'avez pas le droit de supprimer cette tâche !", $crawler->filter('div.alert.alert-danger')->text());
    }

    public function testDeleteTaskActionAnonymeAdmin()
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccessAsAdmin();

        $crawler = $client->request('GET', '/tasks/3/delete');

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        static::assertSame("Superbe ! La tâche a bien été supprimée.", $crawler->filter('div.alert.alert-success')->text());
    }

    public function testDeleteTaskActionAnonymeUser(): void
    {
        $securityControllerTest = new SecurityControllerTest();
        $client = $securityControllerTest->testLoginSuccess();

        $crawler = $client->request('GET', '/tasks/4/delete');

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame("Oops ! Vous n'avez pas le droit de supprimer cette tâche !", $crawler->filter('div.alert.alert-danger')->text());
    }
}
