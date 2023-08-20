<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class Address
{
    public function __construct(public string $value)
    {
    }
}
