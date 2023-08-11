<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use Faker\Factory;
use ShoppingCart\Command\Order\Domain\TotalAmount;

final class TotalAmountObjectMother
{
    public static function make(?int $value = null): TotalAmount
    {
        $faker = Factory::create();
        return new TotalAmount($value ?? $faker->numberBetween(100, 10000));
    }
}
