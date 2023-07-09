<?php

namespace ShoppingCart\Tests\Order\Domain;

use Faker\Factory;
use ShoppingCart\Order\Domain\Name;

final class NameObjectMother
{
    public static function make(?string $name = null): Name
    {
        $faker = Factory::create();
        return new Name($name ?? $faker->name());
    }
}