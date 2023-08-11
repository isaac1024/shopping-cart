<?php

namespace ShoppingCart\Query\NumberItemsCart\Domain;

interface CartRepository
{
    public function search(string $cartId): ?Cart;
}
