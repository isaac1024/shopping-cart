<?php

namespace ShoppingCart\Event\MercurePublisher\Domain;

interface Publisher
{
    public function publish(string $cartId, string $data): void;
}
