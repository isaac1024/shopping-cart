<?php

namespace ShoppingCart\Query\Cart\Application;

use ShoppingCart\Shared\Domain\Bus\Query;

final readonly class CartFinderQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
