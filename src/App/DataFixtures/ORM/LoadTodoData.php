<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Model\Todo;
use App\Model\Item;
use Doctrine\Common\Collections\ArrayCollection;

class LoadTodoData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            $manager->persist(
                new Todo("Todo $i", new ArrayCollection([
                    Item::fromArray(['name' => 'Learn BDD']),
                    Item::fromArray(['name' => 'Learn Gherkin']),
                    Item::fromArray(['name' => 'Learn Behat']),
                ]))
            );
        }

        $manager->flush();
    }
}
