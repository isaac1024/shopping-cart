<?php

namespace ShoppingCart\Tests\Order\Application;

use Faker\Factory;
use ShoppingCart\Order\Application\OrderCreatorCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Order\Domain\ProductCollectionOrderMother;

final class OrderCreatorCommandObjectMother
{
    public static function make(
        ?string $orderId = null,
        ?string $name = null,
        ?string $address = null,
        ?string $cartId = null,
        ?array $productItems = null,
    ): OrderCreatorCommand {
        $faker = Factory::create();
        return new OrderCreatorCommand(
            $orderId ?? UuidUtils::random(),
            $name ?? $faker->name(),
            $address ?? $faker->address(),
            $cartId ?? UuidUtils::random(),
            $productItems ?? ProductCollectionOrderMother::make($faker->numberBetween(1, 5))->toArray(),
        );
    }
}
