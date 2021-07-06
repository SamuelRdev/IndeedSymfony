<?php

namespace App\DataFixtures;


use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture
{

    const __CONTRACTS__ = ["CDI", "CDD", "FREE"];

    public function load(ObjectManager $manager)
    {
        foreach(self::__CONTRACTS__ as $key => $value) {
            
            $slug = strtolower(trim($value));

            $contract = new Contract();
            $contract->setName($value);
            $contract->setSlug($slug);
            
            

            $this->addReference("contract_$key", $contract);
            $manager->persist($contract);
        }


        $manager->flush();
    }
}