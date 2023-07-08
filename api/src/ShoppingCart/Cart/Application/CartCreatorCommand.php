<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Shared\Domain\Bus\Command;

final readonly class CartCreatorCommand implements Command
{
    public function __construct(public string $cartId)
    {
    }
}
