<?php

namespace christopheraseidl\CookieConsent\Config;

use Illuminate\Support\Str;

abstract class BaseConfiguration
{
    protected array $properties = [];

    public function __construct(array $properties = [])
    {
        // Convert camel case keys to snake case for internal storage
        foreach ($properties as $key => $value) {
            $this->properties[Str::snake($key)] = $value;
        }
    }

    public function __get(string $name)
    {
        // Convert camel case key to snake case for retrieval
        return $this->properties[Str::snake($name)] ?? null;
    }

    public function __set(string $name, $value): void
    {
        // Convert camel case key to snake case for storing
        $this->properties[Str::snake($name)] = $value;
    }

    public function __isset(string $name): bool
    {
        // Convert camel case to snake case for existence check
        return isset($this->properties[Str::snake($name)]);
    }

    public function __unset(string $name): void
    {
        // Convert camel case to snake case for removal
        unset($this->properties[Str::snake($name)]);
    }
}