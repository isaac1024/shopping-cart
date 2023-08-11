<?php

namespace ShoppingCart\Tests\Command\Order\Application;

use Faker\Factory;
use ShoppingCart\Command\Order\Application\OrderCreatorCommand;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Order\Domain\ProductCollectionOrderMother;

final class OrderCreatorCommandObjectMother
{
    public static function make(
        ?string $orderId = null,
        ?string $name = null,
        ?string $address = null,
        ?string $cartId = null,
        ?array $productItems = null,
        ?string $cardNumber = null,
        ?string $cardValidDate = null,
        ?string $cardCvv = null,
    ): OrderCreatorCommand {
        $faker = Factory::create();
        return new OrderCreatorCommand(
            $orderId ?? UuidUtils::random(),
            $name ?? $faker->name(),
            $address ?? $faker->address(),
            $cartId ?? UuidUtils::random(),
            $productItems ?? ProductCollectionOrderMother::make($faker->numberBetween(1, 5))->toArray(),
            $cardNumber ?? $faker->creditCardNumber(),
            $cardValidDate ?? $faker->creditCardExpirationDateString(expirationDateFormat: 'm/y'),
            $cardCvv ?? $faker->numerify(),
        );
    }
}
