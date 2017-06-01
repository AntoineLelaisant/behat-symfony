<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Todo
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Item[] */
    private $items;

    public function __construct(string $name, array $items = [])
    {
        $this->name = $name;

        foreach ($items as $item) {
            if (!$item instanceof Item) {
                throw new \InvalidArgumentException(sprintf(
                    '$items should be an instance of App\Model\Item. %s given.',
                    get_class($item)
                ));
            }

            $item->attachTo($this);
        }

        $this->items = new ArrayCollection($items);
    }

    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return Items[]
     */
    public function getItems() : Collection
    {
        return $this->items;
    }

    public function isCompleted() : bool
    {
        foreach ($this->items as $item) {
            if ($item->isPending()) {
                return false;
            }
        }

        return true;
    }

    public function isPending() : bool
    {
        return false === $this->isCompleted();
    }

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }
}
