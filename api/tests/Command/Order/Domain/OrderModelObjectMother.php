<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use DateTimeImmutable;
use Faker\Factory;
use ShoppingCart\Command\Order\Application\OrderCreatorCommand;
use ShoppingCart\Command\Order\Domain\OrderModel;
use ShoppingCart\Command\Order\Domain\Product;
use ShoppingCart\Command\Order\Domain\ProductCollection;
use ShoppingCart\Command\Order\Domain\Status;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class OrderModelObjectMother
{
    public static function make(
        ?string $orderId = null,
        ?string $name = null,
        ?string $address = null,
        ?string $cartId = null,
        ?ProductCollection $productItems = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?AggregateStatus   $aggregateStatus = null,
    ): OrderModel {
        $faker = Factory::create();
        $productItems = $productItems ?? ProductCollectionOrderMother::make($faker->numberBetween(1, 5));
        $now = DateTimeUtils::now();
        return new OrderModel(
            $orderId ?? OrderIdObjectMother::make()->value,
            Status::PENDING_PAYMENT->value,
            $name ?? NameObjectMother::make()->value,
            $address ?? AddressObjectMother::make()->value,
            $cartId ?? CartIdObjectMother::make()->value,
            $productItems->totalQuantity(),
            $productItems->totalAmount(),
            $productItems->toArray(),
            $createdAt ?? $now,
            $updatedAt ?? $now,
            $aggregateStatus ?? AggregateStatus::LOADED,
        );
    }

    public static function fromOrderCreatorCommand(OrderCreatorCommand $command): OrderModel
    {
        $products = array_map(
            function (array $product) {
                return new Product(
                    $product['productId'],
                    $product['title'],
                    $product['unitPrice'],
                    $product['quantity'],
                    $product['totalPrice']
                );
            },
            $command->productItems,
        );

        return OrderModelObjectMother::make(
            $command->orderId,
            $command->name,
            $command->address,
            $command->cartId,
            new ProductCollection(...$products),
            aggregateStatus: AggregateStatus::CREATED,
        );
    }
}
