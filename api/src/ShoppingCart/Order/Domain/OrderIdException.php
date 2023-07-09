<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class OrderIdException extends ShoppingCartException
{
    private const INVALID_ORDER_ID_ERROR_CODE = "invalid_order_id";
    private const INVALID_ORDER_ID_MESSAGE = "Order id '%s' is not a valid uuid.";

    public static function invalidOrderId(string $cartId): OrderIdException
    {
        return new OrderIdException(self::INVALID_ORDER_ID_ERROR_CODE, sprintf(self::INVALID_ORDER_ID_MESSAGE, $cartId));
    }
}
