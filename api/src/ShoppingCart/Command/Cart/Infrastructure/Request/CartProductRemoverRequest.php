<?php

namespace ShoppingCart\Command\Cart\Infrastructure\Request;

final readonly class CartProductRemoverRequest
{
    public function __construct(public string $productId)
    {
    }
}
