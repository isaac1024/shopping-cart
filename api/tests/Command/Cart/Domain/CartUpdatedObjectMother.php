<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use DateTimeImmutable;
use ShoppingCart\Command\Cart\Domain\CartModel;
use ShoppingCart\Command\Cart\Domain\CartUpdated;
use ShoppingCart\Command\Cart\Domain\Product;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class CartUpdatedObjectMother
{
    public static function make(
        ?string            $cartId = null,
        ?ProductCollection $productCollection = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
    ): CartUpdated {
        $productCollection = $productCollection ?? ProductCollection::init();
        $now = DateTimeUtils::now();
        return new CartUpdated(
            $cartId ?? CartIdObjectMother::make()->value,
            $productCollection->totalQuantity(),
            $productCollection->totalAmount(),
            $productCollection->toArray(),
            $createdAt ?? $now,
            $updatedAt ?? $now,
        );
    }

    public static function fromCartModel(CartModel $cart): CartUpdated
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

        return CartUpdatedObjectMother::make(
            CartIdObjectMother::make($cart->cartId),
            $productCollection,
            $cart->createdAt,
            $cart->updatedAt,
        );
    }
}
