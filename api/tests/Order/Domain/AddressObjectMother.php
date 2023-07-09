<?php

namespace ShoppingCart\Tests\Order\Domain;

use Faker\Factory;
use ShoppingCart\Order\Domain\Address;

final class AddressObjectMother
{
    public static function make(?string $address = null): Address
    {
        $faker = Factory::create();
        return new Address($address ?? $faker->address());
    }
}