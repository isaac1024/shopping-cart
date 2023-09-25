<?php

namespace ShoppingCart\Tests\Event\Mercure\Domain;

use Faker\Factory;
use ShoppingCart\Event\MercurePublisher\Application\CartUpdated;
use ShoppingCart\Event\MercurePublisher\Domain\Cart;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartObjectMother
{
    public static function make(?string $cartId = null, ?int $numberItems = null): Cart
    {
        $faker = Factory::create();
        return new Cart(
            $cartId ?? UuidUtils::random(),
            $numberItems ?? $faker->numberBetween(1, 10)
        );
    }

    public static function fromCartUpdated(CartUpdated $cartUpdated): Cart
    {
        return CartObjectMother::make($cartUpdated->aggregateId, $cartUpdated->attributes()['numberItems']);
    }
}
