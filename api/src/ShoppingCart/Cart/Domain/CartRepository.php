<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\Models\CartId;

interface CartRepository
{
    public function save(Cart $cart): void;

    public function find(CartId $cartId): ?Cart;

    public function findProduct(string $productId): ?Product;
}
