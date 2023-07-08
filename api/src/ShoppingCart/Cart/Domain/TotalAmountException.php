<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class TotalAmountException extends ShoppingCartException
{
    private const NEGATIVE_AMOUNT_ERROR_CODE = 'negative_cart_total_amount';
    private const NEGATIVE_AMOUNT_MESSAGE = "Total cart amount can't be negative";

    public static function negativeAmount(): TotalAmountException
    {
        return new TotalAmountException(self::NEGATIVE_AMOUNT_ERROR_CODE, self::NEGATIVE_AMOUNT_MESSAGE);
    }
}
