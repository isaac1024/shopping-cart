<?php

namespace ShoppingCart\Cart\Domain;

interface CartRepository
{
    public function save(Cart $cart): void;

    public function find(CartId $cartId): ?Cart;

    public function findProduct(string $productId): ?Product;
}
