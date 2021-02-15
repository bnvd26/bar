<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends BaseFixture 
{
    public function loadData(ObjectManager $manager)
    {
        $countries = ['Belgium', 'French', 'English', 'Germany'];

        $this->createMany(count($countries), function ($num) use($countries) {
            
            $country = (new Country())
            ->setName($countries[$num])
            ->setAddress($this->faker->address)
            ->setEmail($this->faker->email);

            $this->addReference('country-' . $num, $country);
            return $country;
        });

        $manager->flush();
    }
}