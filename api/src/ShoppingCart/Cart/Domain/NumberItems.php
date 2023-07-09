<?php

namespace ShoppingCart\Cart\Domain;

final readonly class NumberItems
{
    public function __construct(public int $value)
    {
    }

    public static function init(): NumberItems
    {
        return new NumberItems(0);
    }
}
