<?php

namespace ShoppingCart\Command\Cart\Domain;

interface CartRepository
{
    public function save(Cart $cart): void;

    public function search(string $cartId): ?Cart;

    public function findProduct(string $productId): ?Product;
}
