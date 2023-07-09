<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class AddressException extends ShoppingCartException
{
    private const TOO_LONG_ERROR = "long_address";
    private const TOO_LONG_MESSAGE = "Address %s is too long. Max length %d";
    private const EMPTY_ADDRESS_ERROR = "empty_address";
    private const EMPTY_ADDRESS_MESSAGE = "Address is empty.";
    private const ADDRESS_WITH_WHITESPACES_ERROR = "address_with_whitespaces";
    private const ADDRESS_WITH_WHITESPACES_MESSAGE = "Address '%s' contain whitespaces at first or end.";

    public static function nameWithWhitespaces(string $address): AddressException
    {
        return new AddressException(
            self::ADDRESS_WITH_WHITESPACES_ERROR,
            sprintf(self::ADDRESS_WITH_WHITESPACES_MESSAGE, $address)
        );
    }

    public static function emptyAddress(): AddressException
    {
        return new AddressException(self::EMPTY_ADDRESS_ERROR, self::EMPTY_ADDRESS_MESSAGE);
    }

    public static function tooLong(string $address, int $maxLength): AddressException
    {
        return new AddressException(self::TOO_LONG_ERROR, sprintf(self::TOO_LONG_MESSAGE, $address, $maxLength));
    }
}
