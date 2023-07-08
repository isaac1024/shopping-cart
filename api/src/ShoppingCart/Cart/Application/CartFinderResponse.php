<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Shared\Domain\Bus\QueryResponse;

final readonly class CartFinderResponse implements QueryResponse
{
    public function __construct(
        public string $id,
        public string $numberItems,
        public string $totalAmount,
        public array $productItems,
    ) {
    }
}
