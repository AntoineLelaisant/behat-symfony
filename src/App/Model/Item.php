<?php

namespace App\Model;

use App\Exception\UpdateStatusNotAllowedException;

class Item
{
    const STATUS_PENDING = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_CANCELLED = 'cancelled';

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $status;

    /** @var Todo */
    private $todo;

    public function __construct(string $name, Todo $todo)
    {
        $this->name = $name;
        $this->status = self::STATUS_PENDING;

        $this->todo = $todo;
        $this->todo->addItem($this);
    }

    public static function fromArray(array $data = [])
    {
        $data = array_merge([
            'name' => '',
            'todo' => Todo::fromArray([]),
        ], $data);

        return new self($data['name'], $data['todo']);
    }

    public function rename(string $name)
    {
        $this->name = $name;
    }

    public function attachTo(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function validate()
    {
        if (false === $this->isPending()) {
            throw new UpdateStatusNotAllowedException('You can only validate pending item.');
        }

        $this->status = self::STATUS_VALIDATED;
    }

    public function cancel()
    {
        if (false === $this->isPending()) {
            throw new UpdateStatusNotAllowedException('You can only cancel pending item.');
        }

        $this->status = self::STATUS_CANCELLED;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return Todo
     */
    public function getTodo() : Todo
    {
        return $this->todo;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function isPending() : bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isValidated() : bool
    {
        return $this->status === self::STATUS_VALIDATED;
    }

    public function isCancelled() : bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
