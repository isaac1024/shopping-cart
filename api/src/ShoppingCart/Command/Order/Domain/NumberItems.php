<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class NumberItems
{
    public function __construct(public int $value)
    {
    }
}
