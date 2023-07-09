<?php

namespace ShoppingCart\Tests\Order\Domain;

use Faker\Factory;
use ShoppingCart\Order\Domain\TotalAmount;

final class TotalAmountObjectMother
{
    public static function make(?int $value = null): TotalAmount
    {
        $faker = Factory::create();
        return new TotalAmount($value ?? $faker->numberBetween(100, 10000));
    }
}
