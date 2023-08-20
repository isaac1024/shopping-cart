<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class Name
{
    public function __construct(public string $value)
    {
    }
}
