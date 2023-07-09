<?php

namespace ShoppingCart\Tests\Order\Domain;

use ShoppingCart\Order\Domain\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartIdObjectMother
{
    public static function make(?string $id = null): CartId
    {
        return new CartId($id ?? UuidUtils::random());
    }
}
