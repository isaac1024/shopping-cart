<?php

namespace ShoppingCart\Query\NumberItemsCart\Application;

use ShoppingCart\Shared\Domain\Bus\Query;

final readonly class NumberItemsCartFinderQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
