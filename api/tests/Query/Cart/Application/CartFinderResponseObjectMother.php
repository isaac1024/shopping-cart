<?php

namespace ShoppingCart\Tests\Query\Cart\Application;

use Faker\Factory;
use ShoppingCart\Query\Cart\Application\CartFinderResponse;
use ShoppingCart\Query\Cart\Domain\Cart;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartFinderResponseObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?int $numberItems = null,
        ?int $totalAmount = null,
        ?array $productItems = null
    ): CartFinderResponse {
        $faker = Factory::create();

        return new CartFinderResponse(
            $cartId ?? UuidUtils::random(),
            $numberItems ?? $faker->numberBetween(0, 10),
            $totalAmount ?? $faker->numberBetween(100, 10000),
            $productItems ?? []
        );
    }

    public static function fromCart(Cart $cart): CartFinderResponse
    {
        return CartFinderResponse::fromCart($cart);
    }
}
