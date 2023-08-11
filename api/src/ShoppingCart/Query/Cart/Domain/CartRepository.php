<?php

namespace ShoppingCart\Query\Cart\Domain;

interface CartRepository
{
    public function search(string $cartId): ?Cart;
}
