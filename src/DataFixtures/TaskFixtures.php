<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 30; $i++) {
            $task = new Task();

            $task->setTitle('Task ' . $i)
                ->setContent('Contenu du task ' . $i)
                ->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')))
                ->setUser(null);

            if ($i < 15) {
                $task->setIsDone(false);
            } else {
                $task->setIsDone(true);
            }

            $manager->persist($task);
        }

        $manager->flush();
    }
}
