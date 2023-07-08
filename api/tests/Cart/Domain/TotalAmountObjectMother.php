<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Domain\TotalAmount;

final class TotalAmountObjectMother
{
    public static function make(?int $value = null): TotalAmount
    {
        return $value ? new TotalAmount($value) : TotalAmount::init();
    }
}
