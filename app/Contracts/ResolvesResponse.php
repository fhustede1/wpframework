<?php

namespace WeltenretterDev\WPFramework\Contracts;

interface ResolvesResponse
{
    public function resolveResponse(?array $context, ...$args);
}
