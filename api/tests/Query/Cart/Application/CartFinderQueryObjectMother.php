<?php

namespace ShoppingCart\Tests\Query\Cart\Application;

use ShoppingCart\Query\Cart\Application\CartFinderQuery;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartFinderQueryObjectMother
{
    public static function make(?string $id = null): CartFinderQuery
    {
        return new CartFinderQuery($id ?? UuidUtils::random());
    }
}
