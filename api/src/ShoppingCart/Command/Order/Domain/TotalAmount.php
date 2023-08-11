<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class TotalAmount
{
    public function __construct(public int $value)
    {
    }
}
