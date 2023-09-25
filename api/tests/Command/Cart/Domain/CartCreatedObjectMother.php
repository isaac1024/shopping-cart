<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use DateTimeImmutable;
use ShoppingCart\Command\Cart\Domain\CartCreated;
use ShoppingCart\Command\Cart\Domain\CartModel;
use ShoppingCart\Command\Cart\Domain\Product;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class CartCreatedObjectMother
{
    public static function make(
        ?string            $cartId = null,
        ?ProductCollection $productCollection = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
    ): CartCreated {
        $productCollection = $productCollection ?? ProductCollection::init();
        $now = DateTimeUtils::now();
        return new CartCreated(
            $cartId ?? CartIdObjectMother::make()->value,
            $productCollection->totalQuantity(),
            $productCollection->totalAmount(),
            $productCollection->toArray(),
            $createdAt ?? $now,
            $updatedAt ?? $now,
        );
    }

    public static function fromCartModel(CartModel $cart): CartCreated
    {
        $productCollection = new ProductCollection(...array_map(
            function (array $product) {
                return new Product(
                    $product['productId'],
                    $product['title'],
                    $product['photo'],
                    $product['unitPrice'],
                    $product['quantity'],
                    $product['totalPrice']
                );
            },
            $cart->productItems,
        ));

        return CartCreatedObjectMother::make(
            CartIdObjectMother::make($cart->cartId),
            $productCollection,
            $cart->createdAt,
            $cart->updatedAt,
        );
    }
}
