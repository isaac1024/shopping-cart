<?php

namespace ShoppingCart\Tests\Shared\Domain\Models;

use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartIdObjectMother
{
    public static function make(?string $id = null): CartId
    {
        return new CartId($id ?? UuidUtils::random());
    }
}
