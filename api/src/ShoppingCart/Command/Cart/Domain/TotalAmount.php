<?php

namespace ShoppingCart\Command\Cart\Domain;

final readonly class TotalAmount
{
    public function __construct(public int $value)
    {
    }

    public static function init(): TotalAmount
    {
        return new TotalAmount(0);
    }
}
