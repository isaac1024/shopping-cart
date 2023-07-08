<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Application\CartCreatorCommand;
use ShoppingCart\Cart\Application\CartFinderQuery;
use ShoppingCart\Cart\Domain\Cart;
use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Cart\Domain\ProductCollection;

final class CartObjectMother
{
    public static function make(
        ?CartId $cartId = null,
        ?ProductCollection $productCollection = null
    ): Cart {
        $productCollection = $productCollection ?? ProductCollection::init();
        return new Cart(
            $cartId ?? CartIdObjectMother::make(),
            NumberItemsObjectMother::make($productCollection->totalQuantity()),
            TotalAmountObjectMother::make($productCollection->totalAmount()),
            $productCollection,
        );
    }

    public static function fromCartCreatorCommand(CartCreatorCommand $command): Cart
    {
        return CartObjectMother::make(CartIdObjectMother::make($command->cartId));
    }

    public static function fromCartFinderQuery(CartFinderQuery $query): Cart
    {
        return CartObjectMother::make(CartIdObjectMother::make($query->id));
    }
}
