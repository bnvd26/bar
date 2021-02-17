<?php

namespace App\DataFixtures;

use App\Entity\Statistic;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StatisticFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(40, function ($num) {
            $statistic = (new Statistic())
            ->setBeer($this->getReference('beer-' . rand(0, 9)))
            ->setCustomer($this->getReference('customer-' . rand(0, 9)))
            ->setScore($this->faker->numberBetween(1, 10));

            return $statistic;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            BeerFixtures::class,
            CustomerFixtures::class,
        );
    }
}