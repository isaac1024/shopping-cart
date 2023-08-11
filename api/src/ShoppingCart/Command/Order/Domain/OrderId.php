<?php

namespace ShoppingCart\Command\Order\Domain;

use ShoppingCart\Shared\Domain\Models\Uuid;

final readonly class OrderId extends Uuid
{
    protected static function throwException(string $value): never
    {
        throw OrderIdException::invalidOrderId($value);
    }
}
