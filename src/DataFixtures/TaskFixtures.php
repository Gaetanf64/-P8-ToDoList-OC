<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class TaskFixtures extends Fixture implements DependentFixtureInterface
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

        for ($j = 1; $j < 9; $j++) {
            $task = new Task();

            $task->setTitle('Task User' . $j)
                ->setContent('Contenu du task user' . $j)
                ->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')))
                ->setUser($this->getReference('user_' . $j));

            if ($j < 5) {
                $task->setIsDone(false);
            } else {
                $task->setIsDone(true);
            }

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
