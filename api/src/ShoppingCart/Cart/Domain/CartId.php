<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\Models\Uuid;

final readonly class CartId extends Uuid
{
    protected function throwException(): never
    {
        throw CartIdException::invalidCartId($this->value);
    }
}
