<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Application;

use ShoppingCart\Query\NumberItemsCart\Application\NumberItemsCartFinderQuery;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class NumberItemsCartFinderQueryObjectMother
{
    public static function make(?string $id = null): NumberItemsCartFinderQuery
    {
        return new NumberItemsCartFinderQuery($id ?? UuidUtils::random());
    }
}
