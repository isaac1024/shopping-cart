<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use ShoppingCart\Command\Cart\Application\CartCreatorCommand;
use ShoppingCart\Command\Cart\Application\CartProductRemoverCommand;
use ShoppingCart\Command\Cart\Application\CartProductSetterCommand;
use ShoppingCart\Command\Cart\Domain\Cart;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\Timestamps;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class CartObjectMother
{
    public static function make(
        ?CartId $cartId = null,
        ?ProductCollection $productCollection = null,
        ?Timestamps $timestamps = null,
    ): Cart {
        $productCollection = $productCollection ?? ProductCollection::init();
        return new Cart(
            $cartId ?? CartIdObjectMother::make(),
            NumberItemsObjectMother::make($productCollection->totalQuantity()),
            TotalAmountObjectMother::make($productCollection->totalAmount()),
            $productCollection,
            $timestamps ?? Timestamps::init(),
        );
    }

    public static function fromCartCreatorCommand(CartCreatorCommand $command): Cart
    {
        return CartObjectMother::make(CartIdObjectMother::make($command->cartId));
    }

    public static function fromCartProductRemoverCommand(
        CartProductRemoverCommand $command,
        ProductCollection $productCollection
    ): Cart {
        return CartObjectMother::make(CartIdObjectMother::make($command->cartId), $productCollection);
    }

    public static function fromCartProductSetterCommand(
        CartProductSetterCommand $command,
        ProductCollection $productCollection
    ): Cart {
        return CartObjectMother::make(CartIdObjectMother::make($command->cartId), $productCollection);
    }
}
