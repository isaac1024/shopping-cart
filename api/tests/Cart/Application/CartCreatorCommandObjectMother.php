<?php

namespace ShoppingCart\Tests\Cart\Application;

use ShoppingCart\Cart\Application\CartCreatorCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartCreatorCommandObjectMother
{
    public static function make(?string $cartId = null): CartCreatorCommand
    {
        return new CartCreatorCommand($cartId ?? UuidUtils::random());
    }
}
