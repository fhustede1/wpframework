<?php

namespace WeltenretterDev\WPFramework\ViewModel\Iterator;

use WeltenretterDev\WPFramework\Contracts\TransformableModel;
use WeltenretterDev\WPFramework\Contracts\TranslatesToArray;

abstract class BasicViewModelIterator implements ViewModelIterator
{
    private $itemClassString;
    private $items;

    public function __construct($itemClassString)
    {
        $this->itemClassString = $itemClassString;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function checkTypeAndCreateViewModel($item): ?array
    {
        if ($this->checkType($item)) {
            $vm = $this->createViewModel($item);
            return $vm->toArray();
        }

        return null;
    }

    public function checkType($item): bool
    {
        if ($item instanceof $this->itemClassString) {
            return true;
        }

        return false;
    }

    public function iterate()
    {
        $items  = $this->items;
        $tags_vm = null;

        if (!empty($items)) {
            $items = collect($items);

            $tags_vm = $items->map(function ($item) {
                return $this->checkTypeAndCreateViewModel($item);
            });

            return $tags_vm;
        }

        return false;
    }


    abstract protected function createViewModel(TransformableModel $item): TranslatesToArray;
}
