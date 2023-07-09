<?php

namespace ShoppingCart\Order\Domain;

interface OrderRepository
{
    public function save(Order $order): void;
}