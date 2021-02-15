<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Entity\Country;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BeerFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $beers = ['Kronenbourg','Heineken','1664','Leffe','Desperados','Pelforth','Grimbergen','Bavaria','Hoegaarden','33 Export'];

        $this->createMany(count($beers), function ($num) use($beers) {

            $beer = (new Beer())
            ->setName($beers[$num])
            ->setCountryId($this->getReference('country-' . rand(0, 3)))
            ->setDescription($this->faker->text($maxNbChars = 200))
            ->setPrice(rand(10, 200))
            ->setDegree(rand(10, 100))
            ->setPublishedAt($this->faker->dateTime($max = 'now', $timezone = null))
            ->addCategory($this->getReference('category-' . rand(0, 2)));

            return $beer;
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