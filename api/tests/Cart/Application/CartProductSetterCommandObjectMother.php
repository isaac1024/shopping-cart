<?php

namespace ShoppingCart\Tests\Cart\Application;

use Faker\Factory;
use ShoppingCart\Cart\Application\CartProductSetterCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartProductSetterCommandObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?string $productId = null,
        ?int $quantity = null
    ): CartProductSetterCommand {
        $faker = Factory::create();
        return new CartProductSetterCommand(
            $cartId ?? UuidUtils::random(),
            $productId ?? UuidUtils::random(),
            $quantity ?? $faker->numberBetween(1, 10),
        );
    }
}
