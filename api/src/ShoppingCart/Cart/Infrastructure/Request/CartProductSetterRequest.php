<?php

namespace ShoppingCart\Cart\Infrastructure\Request;

final readonly class CartProductSetterRequest
{
    public function __construct(public string $productId, public int $quantity)
    {
    }
}
