<?php

namespace ShoppingCart\Tests\Order\Domain;

use Faker\Factory;
use ShoppingCart\Order\Application\OrderCreatorCommand;
use ShoppingCart\Order\Domain\Address;
use ShoppingCart\Order\Domain\CartId;
use ShoppingCart\Order\Domain\Name;
use ShoppingCart\Order\Domain\NumberItems;
use ShoppingCart\Order\Domain\Order;
use ShoppingCart\Order\Domain\OrderId;
use ShoppingCart\Order\Domain\Product;
use ShoppingCart\Order\Domain\ProductCollection;
use ShoppingCart\Order\Domain\Status;
use ShoppingCart\Order\Domain\TotalAmount;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;

final class OrderObjectMother
{
    public static function make(
        ?OrderId $orderId = null,
        ?Name $name = null,
        ?Address $address = null,
        ?CartId $cartId = null,
        ?NumberItems $numberItems = null,
        ?TotalAmount $totalAmount = null,
        ?ProductCollection $productItems = null,
    ): Order {
        $faker = Factory::create();
        return new Order(
            $orderId ?? OrderIdObjectMother::make(),
            Status::PENDING_PAYMENT,
            $name ?? NameObjectMother::make(),
            $address ?? AddressObjectMother::make(),
            $cartId ?? CartObjectMother::make(),
            $numberItems ?? NumberItemsObjectMother::make(),
            $totalAmount ?? TotalAmountObjectMother::make(),
            $productItems ?? ProductCollectionOrderMother::make($faker->numberBetween(1, 5))
        );
    }

    public static function fromOrderCreatorCommand(OrderCreatorCommand $command)
    {
        $products = new ProductCollection(...array_map(
            fn(array $product) => new Product(
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
            new NumberItems($products->totalQuantity()),
            new TotalAmount($products->totalAmount()),
            $products,
        );
    }
}