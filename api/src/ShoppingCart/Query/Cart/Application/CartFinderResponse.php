<?php

namespace ShoppingCart\Query\Cart\Application;

use ShoppingCart\Query\Cart\Domain\Cart;
use ShoppingCart\Shared\Domain\Bus\QueryResponse;

final readonly class CartFinderResponse implements QueryResponse
{
    public function __construct(
        public string $id,
        public int $numberItems,
        public int $totalAmount,
        public array $productItems,
    ) {
    }

    public static function fromCart(Cart $cart)
    {
        return new CartFinderResponse(
            $cart->id(),
            $cart->numberItems(),
            $cart->totalAmount(),
            $cart->productItems()
        );
    }
}
