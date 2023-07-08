<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartIdObjectMother
{
    public static function make(?string $id = null): CartId
    {
        return new CartId($id ?? UuidUtils::random());
    }
}
