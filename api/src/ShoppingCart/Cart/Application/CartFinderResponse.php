<?php

namespace ShoppingCart\Cart\Application;

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
}
