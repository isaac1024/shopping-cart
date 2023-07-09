<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class NumberItemsException extends ShoppingCartException
{
    private const ORDER_WITHOUT_ITEMS_ERROR_CODE = 'negative_order_number_items';
    private const ORDER_WITHOUT_ITEMS_MESSAGE = "Total order items must be greater than 0";

    public static function orderWithoutItems(): NumberItemsException
    {
        return new NumberItemsException(self::ORDER_WITHOUT_ITEMS_ERROR_CODE, self::ORDER_WITHOUT_ITEMS_MESSAGE);
    }
}
