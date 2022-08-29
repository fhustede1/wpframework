<?php

namespace WeltenretterDev\WPFramework\Contracts;

interface CanIterateViewModels extends CanIterateCollections
{
    public function setItems(array $items);
    public function checkTypeAndCreateViewModel($item): ?array;
    public function checkType($item): bool;
}
