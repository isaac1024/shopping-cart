<?php

namespace ShoppingCart\Tests\Cart\Application;

use Faker\Factory;
use ShoppingCart\Cart\Application\CartFinderResponse;
use ShoppingCart\Cart\Domain\Cart;
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
        return new CartFinderResponse(
            $cart->getCartId(),
            $cart->getNumberItems(),
            $cart->getTotalAmount(),
            $cart->getProductItems()
        );
    }
}
