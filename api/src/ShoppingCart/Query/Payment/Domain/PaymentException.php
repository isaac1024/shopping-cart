<?php

namespace ShoppingCart\Query\Payment\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class PaymentException extends ShoppingCartException
{
    private const NOT_FOUND_ERROR = 'payment_not_found';
    private const NOT_FOUND_ERROR_MESSAGE = 'Not found payment with id "%s"';

    public static function notfound(string $paymentId): PaymentException
    {
        return new PaymentException(self::NOT_FOUND_ERROR, sprintf(self::NOT_FOUND_ERROR_MESSAGE, $paymentId));
    }
}
