<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use ShoppingCart\Command\Cart\Application\CartProductRemoverCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartProductRemoverCommandObjectMother
{
    public static function make(?string $cartId = null, ?string $productId = null): CartProductRemoverCommand
    {
        return new CartProductRemoverCommand(
            $cartId ?? UuidUtils::random(),
            $productId ?? UuidUtils::random(),
        );
    }
}
