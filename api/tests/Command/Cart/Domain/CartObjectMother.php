<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use ShoppingCart\Command\Cart\Application\CartCreatorCommand;
use ShoppingCart\Command\Cart\Domain\Cart;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

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
}
