<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class NameException extends ShoppingCartException
{
    private const TOO_LONG_ERROR = "long_name";
    private const TOO_LONG_MESSAGE = "Name %s is too long. Max length %d";
    private const EMPTY_NAME_ERROR = "empty_name";
    private const EMPTY_NAME_MESSAGE = "Name is empty.";
    private const NAME_WITH_WHITESPACES_ERROR = "name_with_whitespaces";
    private const NAME_WITH_WHITESPACES_MESSAGE = "Name '%s' contain whitespaces at first or end.";

    public static function nameWithWhitespaces(string $name): NameException
    {
        return new NameException(self::NAME_WITH_WHITESPACES_ERROR, sprintf(self::NAME_WITH_WHITESPACES_MESSAGE, $name));
    }

    public static function emptyName(): NameException
    {
        return new NameException(self::EMPTY_NAME_ERROR, self::EMPTY_NAME_MESSAGE);
    }

    public static function tooLong(string $name, int $maxLength): NameException
    {
        return new NameException(self::TOO_LONG_ERROR, sprintf(self::TOO_LONG_MESSAGE, $name, $maxLength));
    }
}