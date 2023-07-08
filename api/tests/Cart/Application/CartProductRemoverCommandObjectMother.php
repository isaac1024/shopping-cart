<?php

namespace ShoppingCart\Tests\Cart\Application;

use ShoppingCart\Cart\Application\CartProductRemoverCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

class CartProductRemoverCommandObjectMother
{
    public static function make(?string $cartId = null, ?string $productId = null): CartProductRemoverCommand
    {
        return new CartProductRemoverCommand(
            $cartId ?? UuidUtils::random(),
            $productId ?? UuidUtils::random(),
        );
    }
}
