<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class SetCustomerNumberBeerFixtures extends BaseFixture implements DependentFixtureInterface
{

    public function __construct(CustomerRepository $customerRepo, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->customerRepo = $customerRepo;
    }

    public function loadData(ObjectManager $manager)
    {
       foreach($this->customerRepo->findAll() as $customer) {
            $customer->setNumberBeer(count($customer->getStatistics()));
            $this->em->persist($customer);
            $this->em->flush();
       }
    }

    public function getDependencies()
    {
        return array(
            StatisticFixtures::class
        );
    }
}