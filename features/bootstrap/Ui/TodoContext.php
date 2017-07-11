<?php

namespace features\bootstrap\Ui;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;

class TodoContext extends RawMinkContext implements Context
{
    /**
     * @Then I should see a list of todos
     */
    public function iShouldSeeAListOfTodos()
    {
        $cards = $this->getSession()->getPage()->findAll('css', '.card');

        if (count($cards) < 1) {
            throw new \Exception('Too few cards');
        }
    }

    /**
     * @When I search for :search
     */
    public function iSearchFor($search)
    {
        $page = $this->getSession()->getPage();

        $searchField = $page->find('css', 'nav input[data-role="search"]');
        $searchField->setValue($search);

        $submitButton = $page->find('css', 'nav button[type="submit"]');
        $submitButton->press();
    }

    /**
     * @Then I should see one todo listed
     */
    public function iShouldSeeOneTodoListed()
    {
        $cards = $this->getSession()->getPage()->findAll('css', '.card');

        if (count($cards) !== 1) {
            throw new \Exception('There\'s more than one card.');
        }
    }

    /**
     * @Then I should see the todo :name
     */
    public function iShouldSeeTheTodo($name)
    {
        $cards = $this->getSession()->getPage()->findAll('css', '.card');

        foreach ($cards as $card) {
            $title = $card->find('css', '.card-header')->getText();

            if ($title === $name) {
                return;
            }
        }

        throw new \Exception('The todo named' . $name . ' was not found');
    }
}
