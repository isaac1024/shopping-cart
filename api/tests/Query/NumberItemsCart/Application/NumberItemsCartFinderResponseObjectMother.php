<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Application;

use Faker\Factory;
use ShoppingCart\Query\NumberItemsCart\Application\NumberItemsCartFinderResponse;
use ShoppingCart\Query\NumberItemsCart\Domain\Cart;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class NumberItemsCartFinderResponseObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?int $numberItems = null,
    ): NumberItemsCartFinderResponse {
        $faker = Factory::create();

        return new NumberItemsCartFinderResponse(
            $cartId ?? UuidUtils::random(),
            $numberItems ?? $faker->numberBetween(0, 10),
        );
    }

    public static function fromCart(Cart $cart): NumberItemsCartFinderResponse
    {
        return NumberItemsCartFinderResponse::fromCart($cart);
    }
}
