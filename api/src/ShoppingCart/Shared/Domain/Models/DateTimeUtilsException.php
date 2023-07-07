<?php

namespace ShoppingCart\Shared\Domain\Models;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class DateTimeUtilsException extends ShoppingCartException
{
    public static function invalidDateTimeFormat(string $dateTime, string $format): DateTimeUtilsException
    {
        return new DateTimeUtilsException(
            "invalid_datetime_format",
            sprintf("Date time '%s' is not valid. Valid format '%s'", $dateTime, $format)
        );
    }
}
