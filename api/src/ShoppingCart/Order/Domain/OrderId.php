<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\Models\Uuid;

final readonly class OrderId extends Uuid
{
    protected function throwException(): never
    {
        throw OrderIdException::invalidOrderId($this->value);
    }
}