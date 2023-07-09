<?php

namespace ShoppingCart\Tests\Order\Domain;

use ShoppingCart\Order\Domain\OrderId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class OrderIdObjectMother
{
    public static function make(?string $id = null): OrderId
    {
        return new OrderId($id ?? UuidUtils::random());
    }
}
