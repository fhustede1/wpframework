<?php

namespace WeltenretterDev\WPFramework\ViewModel\Iterator;

interface ViewModelIterator
{
    public function setItems(array $items);
    public function iterate();
    public function checkTypeAndCreateViewModel($item): ?array;
    public function checkType($item): bool;
}
