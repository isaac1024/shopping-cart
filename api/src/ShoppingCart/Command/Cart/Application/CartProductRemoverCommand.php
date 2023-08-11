<?php

namespace ShoppingCart\Command\Cart\Application;

use ShoppingCart\Shared\Domain\Bus\Command;

final readonly class CartProductRemoverCommand implements Command
{
    public function __construct(public string $cartId, public string $productId)
    {
    }
}
