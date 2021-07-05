<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return[ContractFixtures::class];
        return[ContractTypeFixtures::class];
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for($i=0; $i<10; $i++){

            $offer = new Offer();
            $offer
                ->setTitle($faker->sentence())
                ->setContent($faker->text($maxNbChars = 200))
                ->setAddress($faker->streetAddress())
                ->setPostalCode($faker->postcode())
                ->setCity($faker->city())
                ->setCreatedAt($faker->dateTimeAD($max = 'now', $timezone =null))
                ->setUpdatedAt($faker->dateTimeAD($max = 'now', $timezone =null))
                ->setEndedAt($faker->dateTimeAD($max = 'now', $timezone =null));
               

                $contract = $this->getReference("contract_" . rand(0, 2));
                $offer->setContract($contract);

                $contract_type = $this->getReference("contract_type_" . rand(0, 1));
                $offer->setContractType($contract_type);

                $manager->persist($offer);
        }

        $manager->flush();
    }
}
