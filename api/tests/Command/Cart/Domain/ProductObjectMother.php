<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use Faker\Factory;
use ShoppingCart\Command\Cart\Domain\Product;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class ProductObjectMother
{
    public static function make(
        ?string $productId = null,
        ?string $title = null,
        ?int $unitPrice = null,
        ?int $quantity = null,
        ?int $totalPrice = null,
    ): Product {
        $faker = Factory::create();

        $unitPrice = $unitPrice ?? $faker->numberBetween(100, 10000);
        $quantity = $quantity ?? $faker->numberBetween(1, 10);
        $totalPrice = $totalPrice ?? $unitPrice * $quantity;
        return new Product(
            $productId ?? UuidUtils::random(),
            $title ?? $faker->title(),
            $unitPrice,
            $quantity,
            $totalPrice,
        );
    }
}
