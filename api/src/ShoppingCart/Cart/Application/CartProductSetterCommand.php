<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Shared\Domain\Bus\Command;

final readonly class CartProductSetterCommand implements Command
{
    public function __construct(public string $cartId, public string $productId, public int $quantity)
    {
    }
}
