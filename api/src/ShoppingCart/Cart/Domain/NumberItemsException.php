<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class NumberItemsException extends ShoppingCartException
{
    private const NEGATIVE_QUANTITY_ERROR_CODE = 'negative_cart_number_items';
    private const NEGATIVE_QUANTITY_MESSAGE = "Total cart items can't be negative";

    public static function negativeQuantity(): NumberItemsException
    {
        return new NumberItemsException(self::NEGATIVE_QUANTITY_ERROR_CODE, self::NEGATIVE_QUANTITY_MESSAGE);
    }
}
