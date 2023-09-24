<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use Faker\Factory;
use ShoppingCart\Command\Order\Application\OrderCreatorCommand;
use ShoppingCart\Command\Order\Domain\Address;
use ShoppingCart\Command\Order\Domain\Name;
use ShoppingCart\Command\Order\Domain\Order;
use ShoppingCart\Command\Order\Domain\OrderId;
use ShoppingCart\Command\Order\Domain\Product;
use ShoppingCart\Command\Order\Domain\ProductCollection;
use ShoppingCart\Command\Order\Domain\Status;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\Timestamps;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class OrderObjectMother
{
    public static function make(
        ?OrderId $orderId = null,
        ?Name $name = null,
        ?Address $address = null,
        ?CartId $cartId = null,
        ?ProductCollection $productItems = null,
        ?Timestamps $timestamps = null,
    ): Order {
        $faker = Factory::create();
        $productItems = $productItems ?? ProductCollectionOrderMother::make($faker->numberBetween(1, 5));

        return new Order(
            $orderId ?? OrderIdObjectMother::make(),
            Status::PENDING_PAYMENT,
            $name ?? NameObjectMother::make(),
            $address ?? AddressObjectMother::make(),
            $cartId ?? CartIdObjectMother::make(),
            NumberItemsObjectMother::make($productItems->totalQuantity()),
            TotalAmountObjectMother::make($productItems->totalAmount()),
            $productItems,
            $timestamps ?? Timestamps::init(),
        );
    }

    public static function fromOrderCreatorCommand(OrderCreatorCommand $command): Order
    {
        $products = new ProductCollection(...array_map(
            fn (array $product) => new Product(
                $product['productId'],
                $product['title'],
                $product['unitPrice'],
                $product['quantity'],
                $product['totalPrice'],
            ),
            $command->productItems
        ));
        return OrderObjectMother::make(
            new OrderId($command->orderId),
            new Name($command->name),
            new Address($command->address),
            new CartId($command->cartId),
            $products,
        );
    }
}
