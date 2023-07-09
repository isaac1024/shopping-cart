<?php

namespace ShoppingCart\Shared\Domain\Models;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class CartIdException extends ShoppingCartException
{
    private const INVALID_CART_ID_ERROR_CODE = "invalid_cart_id";
    private const INVALID_CART_ID_MESSAGE = "Cart id '%s' is not a valid uuid.";

    public static function invalidCartId(string $cartId): CartIdException
    {
        return new CartIdException(self::INVALID_CART_ID_ERROR_CODE, sprintf(self::INVALID_CART_ID_MESSAGE, $cartId));
    }
}
