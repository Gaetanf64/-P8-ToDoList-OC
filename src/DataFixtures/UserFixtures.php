<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            1 => [
                'email' => 'gaetan.fouillet@gmail.com',
                'username' => 'Gaetan',
                'password' => 'gaetan',
                'roles' => 'ROLE_ADMIN',
            ],
            2 => [
                'email' => 'leo@gmail.com',
                'username' => 'Leo',
                'password' => 'leo',
                'roles' => 'ROLE_USER',
            ],
            3 => [
                'email' => 'thierry@gmail.com',
                'username' => 'Thierry',
                'password' => 'thierry',
                'roles' => 'ROLE_USER',
            ],
            4 => [
                'email' => 'valerie@gmail.com',
                'username' => 'Valerie',
                'password' => 'valerie',
                'roles' => 'ROLE_USER',
            ],
            5 => [
                'email' => 'frederic@gmail.com',
                'username' => 'Frederic',
                'password' => 'frederic',
                'roles' => 'ROLE_USER',
            ],
            6 => [
                'email' => 'laurent@gmail.com',
                'username' => 'Laurent',
                'password' => 'laurent',
                'roles' => 'ROLE_USER',
            ],
            7 => [
                'email' => 'sophie@gmail.com',
                'username' => 'Sophie',
                'password' => 'sophie',
                'roles' => 'ROLE_USER',
            ],
            8 => [
                'email' => 'emma@gmail.com',
                'username' => 'Emma',
                'password' => 'emma',
                'roles' => 'ROLE_USER',
            ],
        ];

        foreach ($users as $key => $value) {
            $user = new User();

            $user->setEmail($value['email']);
            $user->setUsername($value['username']);
            $user->setRoles(array($value['roles']));

            $password = $this->encoder->encodePassword($user, $value['password']);
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
