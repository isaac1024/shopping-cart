<?php

namespace ShoppingCart\Tests\Query\Product\Domain;

use Faker\Factory;
use ShoppingCart\Query\Product\Domain\Product;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class ProductObjectMother
{
    /**
     * @psalm-suppress PossiblyInvalidArgument
     * @psalm-suppress PossiblyInvalidCast
     */
    public static function make(
        ?string $id = null,
        ?string $title = null,
        ?string $description = null,
        ?string $photo = null,
        ?int $price = null
    ): Product {
        $faker = Factory::create();
        return new Product(
            $id ?? UuidUtils::random(),
            $title ?? $faker->words(5, true),
            $description ?? $faker->paragraph(),
            $photo ?? $faker->url(),
            $price ?? $faker->numberBetween(100, 1000),
        );
    }
}
