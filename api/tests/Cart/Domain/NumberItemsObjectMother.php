<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Domain\NumberItems;

final class NumberItemsObjectMother
{
    public static function make(?int $value = null): NumberItems
    {
        return $value ? new NumberItems($value) : NumberItems::init();
    }
}
