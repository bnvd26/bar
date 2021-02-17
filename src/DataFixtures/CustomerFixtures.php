<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, function ($num) {
            $customer = (new Customer())
            ->setEmail($this->faker->email)
            ->setName($this->faker->userName)
            ->setNumberBeer(0)
            ->setAge($this->faker->numberBetween(18, 70))
            ->setWeight($this->faker->randomFloat($nbMaxDecimals = 3, $min = 1, $max = 3));

            $this->addReference('customer-' . $num, $customer);

            return $customer;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CountryFixtures::class,
            CategoryFixtures::class,
        );
    }
}