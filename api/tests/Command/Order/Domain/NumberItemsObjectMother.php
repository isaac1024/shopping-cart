<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use Faker\Factory;
use ShoppingCart\Command\Order\Domain\NumberItems;

final class NumberItemsObjectMother
{
    public static function make(?int $value = null): NumberItems
    {
        $faker = Factory::create();
        return new NumberItems($value ?? $faker->numberBetween(1, 5));
    }
}
