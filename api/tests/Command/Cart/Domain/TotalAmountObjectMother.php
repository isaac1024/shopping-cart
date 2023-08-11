<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use ShoppingCart\Command\Cart\Domain\TotalAmount;

final class TotalAmountObjectMother
{
    public static function make(?int $value = null): TotalAmount
    {
        return $value ? new TotalAmount($value) : TotalAmount::init();
    }
}
