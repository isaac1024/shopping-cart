<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Application\CartCreatorCommand;
use ShoppingCart\Cart\Domain\Cart;
use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Cart\Domain\NumberItems;
use ShoppingCart\Cart\Domain\ProductCollection;
use ShoppingCart\Cart\Domain\TotalAmount;

final class CartObjectMother
{
    public static function make(
        ?CartId $cartId = null,
        ?NumberItems $numberItems = null,
        ?TotalAmount $totalAmount = null,
        ?ProductCollection $productCollection = null
    ): Cart {
        return new Cart(
            $cartId ?? CartIdObjectMother::make(),
            $numberItems ?? NumberItems::init(),
            $totalAmount ?? TotalAmount::init(),
            $productCollection ?? ProductCollection::init(),
        );
    }

    public static function fromCartCreatorCommand(CartCreatorCommand $command): Cart
    {
        return CartObjectMother::make(CartIdObjectMother::make($command->cartId));
    }
}
