<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class NumberItems
{
    public function __construct(public int $value)
    {
    }

    public static function create(int $value): NumberItems
    {
        if ($value <= 0) {
            throw NumberItemsException::orderWithoutItems();
        }

        return new NumberItems($value);
    }
}
