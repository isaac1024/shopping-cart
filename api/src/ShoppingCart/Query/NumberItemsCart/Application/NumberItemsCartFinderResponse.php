<?php

namespace ShoppingCart\Query\NumberItemsCart\Application;

use ShoppingCart\Query\NumberItemsCart\Domain\Cart;
use ShoppingCart\Shared\Domain\Bus\QueryResponse;

final readonly class NumberItemsCartFinderResponse implements QueryResponse
{
    public function __construct(
        public string $id,
        public int $numberItems,
    ) {
    }

    public static function fromCart(Cart $cart): NumberItemsCartFinderResponse
    {
        return new NumberItemsCartFinderResponse(
            $cart->id(),
            $cart->numberItems(),
        );
    }
}
