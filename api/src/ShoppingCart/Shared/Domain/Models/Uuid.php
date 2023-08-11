<?php

namespace ShoppingCart\Shared\Domain\Models;

abstract readonly class Uuid
{
    final public function __construct(public string $value)
    {
    }

    final public static function create(string $value): static
    {
        if (!UuidUtils::isValid($value)) {
            static::throwException($value);
        }

        return new static($value);
    }

    abstract protected static function throwException(string $value): never;

    final public function __toString(): string
    {
        return $this->value;
    }
}
