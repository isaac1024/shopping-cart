<?php

namespace ShoppingCart\Shared\Domain\Models;

final readonly class CartId extends Uuid
{
    protected static function throwException(string $value): never
    {
        throw CartIdException::invalidCartId($value);
    }
}
