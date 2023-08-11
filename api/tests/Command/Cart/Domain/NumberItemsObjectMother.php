<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use ShoppingCart\Command\Cart\Domain\NumberItems;

final class NumberItemsObjectMother
{
    public static function make(?int $value = null): NumberItems
    {
        return $value ? new NumberItems($value) : NumberItems::init();
    }
}
