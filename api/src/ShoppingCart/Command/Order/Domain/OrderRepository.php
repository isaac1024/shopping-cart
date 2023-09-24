<?php

namespace ShoppingCart\Command\Order\Domain;

interface OrderRepository
{
    public function save(OrderModel $order): void;
}
