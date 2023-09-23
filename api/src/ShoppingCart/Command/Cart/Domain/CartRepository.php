<?php

namespace ShoppingCart\Command\Cart\Domain;

interface CartRepository
{
    public function save(CartModel $cart): void;

    public function search(string $cartId): ?Cart;

    public function searchProduct(string $productId): ?Product;
}
