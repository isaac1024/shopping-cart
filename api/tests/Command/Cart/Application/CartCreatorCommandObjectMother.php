<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use ShoppingCart\Command\Cart\Application\CartCreatorCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartCreatorCommandObjectMother
{
    public static function make(?string $cartId = null): CartCreatorCommand
    {
        return new CartCreatorCommand($cartId ?? UuidUtils::random());
    }
}
