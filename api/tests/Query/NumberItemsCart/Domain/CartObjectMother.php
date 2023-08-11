<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Domain;

use Faker\Factory;
use ShoppingCart\Query\NumberItemsCart\Application\NumberItemsCartFinderQuery;
use ShoppingCart\Query\NumberItemsCart\Domain\Cart;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class CartObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?int $quantity = null
    ): Cart {
        $faker = Factory::create();

        return new Cart(
            $cartId ?? UuidUtils::random(),
            $quantity ?? $faker->numberBetween(1, 10),
        );
    }

    public static function fromCartFinderQuery(NumberItemsCartFinderQuery $query): Cart
    {
        return CartObjectMother::make($query->id);
    }
}
