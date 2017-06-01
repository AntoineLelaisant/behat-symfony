<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Model\Todo;
use App\Model\Item;

class LoadTodoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            $manager->persist(
                new Todo("Todo $i", [
                    new Item('Apprendre le BDD'),
                    new Item('Apprendre Gherkin'),
                    new Item('Apprendre Behat')
                ])
            );
        }

        $manager->flush();
    }
}
