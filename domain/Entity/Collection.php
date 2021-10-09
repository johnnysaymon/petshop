<?php

declare(strict_types=1);

namespace App\Domain\Entity;

abstract class Collection
{
    private array $itemList = [];

    protected function addItem($item): void
    {
        $this->itemList[] = $item;
    }

    protected function getItemList(): array
    {
        return $this->itemList;
    }

    protected function setItemList(array $itemList): void
    {
        $this->itemList = $itemList;
    }
}
