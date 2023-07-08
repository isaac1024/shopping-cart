<?php

namespace ShoppingCart\Tests\Cart\Application;

use ShoppingCart\Cart\Application\CartFinderQuery;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartFinderQueryObjectMother
{
    public static function make(?string $id = null): CartFinderQuery
    {
        return new CartFinderQuery($id ?? UuidUtils::random());
    }
}
