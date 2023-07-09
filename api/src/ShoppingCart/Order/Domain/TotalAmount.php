<?php

namespace ShoppingCart\Order\Domain;

final readonly class TotalAmount
{
    public function __construct(public int $value)
    {
    }
}
