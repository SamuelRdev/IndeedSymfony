<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UsersFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++)
        {
            $users = new User;
            $users 
                ->setEmail($faker->email())
                ->setUsername($faker->userName())
                ->setPassword($faker->password());

                $manager->persist($users);
        }
        $manager->flush();
    }
}
