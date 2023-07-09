<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class TotalAmountException extends ShoppingCartException
{
    private const NO_AMOUNT_ERROR_CODE = 'no_order_total_amount';
    private const NO_AMOUNT_MESSAGE = "Total amount must be greater than 0";

    public static function noAmount(): TotalAmountException
    {
        return new TotalAmountException(self::NO_AMOUNT_ERROR_CODE, self::NO_AMOUNT_MESSAGE);
    }
}
