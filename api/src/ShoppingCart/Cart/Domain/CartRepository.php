<?php

namespace ShoppingCart\Cart\Domain;

interface CartRepository
{
    public function save(Cart $cart): void;
}
