<?php

namespace ShoppingCart\Shared\Domain\Models;

final readonly class CartId extends Uuid
{
    protected function throwException(): never
    {
        throw CartIdException::invalidCartId($this->value);
    }
}
