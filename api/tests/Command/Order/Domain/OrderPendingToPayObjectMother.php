<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use Faker\Factory;
use ShoppingCart\Command\Order\Application\OrderCreatorCommand;
use ShoppingCart\Command\Order\Domain\Order;
use ShoppingCart\Command\Order\Domain\OrderPendingToPay;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class OrderPendingToPayObjectMother
{
    public static function make(
        ?string $orderId = null,
        ?string $name = null,
        ?int $totalAmount = null,
        ?string $cardNumber = null,
        ?string $cardValidDate = null,
        ?string $cardCvv = null,
    ): OrderPendingToPay {
        $faker = Factory::create();
        return new OrderPendingToPay(
            $orderId ?? UuidUtils::random(),
            $name ?? $faker->name(),
            $totalAmount ?? $faker->numberBetween(1, 10000),
            $cardNumber ?? $faker->creditCardNumber(),
            $cardValidDate ?? $faker->creditCardExpirationDateString(expirationDateFormat: 'm/y'),
            $cardCvv ?? $faker->numerify(),
        );
    }

    public static function fromOrderAndCommand(Order $order, OrderCreatorCommand $command): OrderPendingToPay
    {
        return OrderPendingToPayObjectMother::make(
            $command->orderId,
            $command->name,
            $order->totalAmount(),
            $command->cardNumber,
            $command->cardValidDate,
            $command->cardCvv,
        );
    }
}
