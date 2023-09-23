<?php

namespace ShoppingCart\Tests\Query\Cart\Domain;

use ShoppingCart\Query\Cart\Application\CartFinderQuery;
use ShoppingCart\Query\Cart\Domain\Cart;
use ShoppingCart\Query\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?ProductCollection $productCollection = null
    ): Cart {
        $productCollection = $productCollection ?? new ProductCollection();
        return new Cart(
            $cartId ?? UuidUtils::random(),
            $productCollection->totalQuantity(),
            $productCollection->totalAmount(),
            $productCollection,
        );
    }

    public static function fromCartFinderQuery(CartFinderQuery $query): Cart
    {
        return CartObjectMother::make($query->id);
    }
}
