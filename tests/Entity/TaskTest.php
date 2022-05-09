<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Task;
use DateTime;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskTest extends KernelTestCase
{
    private const NOT_BLANK_CONSTRAINT_MESSAGE = "Ce champ est requis !";

    private const VALID_TITLE_VALUE = "Test";

    private const VALID_CONTENT_VALUE = "Contenu Test";

    private const VALID_IS_DONE_VALUE = false;

    protected function setUp(): void
    {
        static::bootKernel();
        $container = self::$kernel->getContainer()->get('test.service_container');
        $this->validator = $container->get('validator');
    }

    /**
     * Test Task Valid
     * 
     */
    public function testTaskIsValid()
    {
        $task = new Task();

        //On vérifie les set
        $task->setTitle(self::VALID_TITLE_VALUE)
            ->setContent(self::VALID_CONTENT_VALUE)
            ->setIsDone(self::VALID_IS_DONE_VALUE)
            ->setCreatedAt(new DateTime());

        //On vérifie les get
        $this->assertEquals(self::VALID_TITLE_VALUE, $task->getTitle());
        $this->assertEquals(self::VALID_CONTENT_VALUE, $task->getContent());
        $this->assertEquals(self::VALID_IS_DONE_VALUE, $task->getIsDone());
        $this->assertInstanceOf(DateTime::class, $task->getCreatedAt());

        //Nombre d'erreurs attendues = 0
        $this->getValidationErrors($task, 0);
    }

    /**
     * Test Task Invalid because no Title
     * 
     */
    public function testTaskIsInvalidBecauseNoTitle(): void
    {
        $task = new Task();

        //On vérifie les set
        $task->setContent(self::VALID_CONTENT_VALUE)
            ->setIsDone(self::VALID_IS_DONE_VALUE)
            ->setCreatedAt(new DateTime());

        //On vérifie les get
        $this->assertEquals(self::VALID_CONTENT_VALUE, $task->getContent());
        $this->assertEquals(self::VALID_IS_DONE_VALUE, $task->getIsDone());
        $this->assertInstanceOf(DateTime::class, $task->getCreatedAt());

        //Nombre d'erreurs attendues = 1
        $errors = $this->getValidationErrors($task, 1);

        //Retour du message = message assert de l'entité
        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }

    /**
     * Test Task Invalid because no Content
     * 
     */
    public function testTaskIsInvalidBecauseNoContent(): void
    {
        $task = new Task();

        //On vérifie les set
        $task->setTitle(self::VALID_TITLE_VALUE)
            ->setIsDone(self::VALID_IS_DONE_VALUE)
            ->setCreatedAt(new DateTime());

        //On vérifie les get
        $this->assertEquals(self::VALID_TITLE_VALUE, $task->getTitle());
        $this->assertEquals(self::VALID_IS_DONE_VALUE, $task->getIsDone());
        $this->assertInstanceOf(DateTime::class, $task->getCreatedAt());

        //Nombre d'erreurs attendues = 1
        $errors = $this->getValidationErrors($task, 1);

        //Retour du message = message assert de l'entité
        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }

    /**
     * Gestion des erreurs
     * 
     */
    private function getValidationErrors(Task $task, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($task);

        $this->assertCount($numberOfExpectedErrors, $errors);

        return $errors;
    }
}
