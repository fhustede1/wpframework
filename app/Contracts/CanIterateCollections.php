<?php

namespace WeltenretterDev\WPFramework\Contracts;

use Illuminate\Support\Collection;

interface CanIterateCollections
{
    public function iterate(): ?Collection;
}
