<?php

namespace ShoppingCart\Tests\Order\Domain;

use Faker\Factory;
use ShoppingCart\Order\Application\OrderCreatorCommand;
use ShoppingCart\Order\Domain\OrderPendingToPay;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class OrderPendingToPayObjectMother
{
    public static function make(
        ?string $orderId = null,
        ?string $cardNumber = null,
        ?string $cardValidDate = null,
        ?string $cardCvv = null,
    ): OrderPendingToPay {
        $faker = Factory::create();
        return new OrderPendingToPay(
            $orderId ?? UuidUtils::random(),
            $cardNumber ?? $faker->creditCardNumber(),
            $cardValidDate ?? $faker->creditCardExpirationDateString(expirationDateFormat: 'm/y'),
            $cardCvv ?? $faker->numerify(),
        );
    }

    public static function fromOrderCreatorCommand(OrderCreatorCommand $command): OrderPendingToPay
    {
        return OrderPendingToPayObjectMother::make(
            $command->orderId,
            $command->cardNumber,
            $command->cardValidDate,
            $command->cardCvv,
        );
    }
}