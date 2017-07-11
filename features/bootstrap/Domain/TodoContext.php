<?php

namespace features\bootstrap\Domain;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use App\Model\Todo;

class TodoContext implements Context
{
    protected $todoRepository;

    protected $todos;

    public function __construct($doctrine)
    {
        $this->todoRepository = $doctrine->getManager()->getRepository(Todo::class);
    }

    /**
     * @Given I am on homepage
     */
    public function iAmOnHomepage()
    {
        $this->todos = $this->todoRepository->findAll();
    }

    /**
     * @When I search for :search
     */
    public function iSearchFor($search)
    {
        $this->todos = $this->todoRepository->findByName($search);
    }

    /**
     * @Then I should see a list of todos
     */
    public function iShouldSeeAListOfTodos()
    {
        if (count($this->todos) < 1) {
            throw new \Exception('There\'s too few todos');
        }
    }

    /**
     * @Then I should see one todo listed
     */
    public function iShouldSeeOneTodoListed()
    {
        if (count($this->todos) !== 1) {
            throw new \Exception('There\'s too few todos');
        }
    }

    /**
     * @Then I should see the todo :search
     */
    public function iShouldSeeTheTodo($search)
    {
        foreach ($this->todos as $todo) {
            if ($todo->getName() === $search) {
                return;
            }
        }

        throw new \Exception('Todo named '. $search . ' was not found');
    }
}
