<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use ShoppingCart\Command\Order\Domain\OrderId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class OrderIdObjectMother
{
    public static function make(?string $id = null): OrderId
    {
        return new OrderId($id ?? UuidUtils::random());
    }
}
