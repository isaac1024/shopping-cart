<?php

namespace ShoppingCart\Order\Domain;

final readonly class Address
{
    private const MAX_LENGTH = 255;

    public function __construct(public string $value)
    {
    }

    public static function create(string $value): Address
    {
        if ($value !== trim($value)) {
            throw AddressException::nameWithWhitespaces($value);
        }

        if (empty($value)) {
            throw AddressException::emptyAddress();
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw AddressException::tooLong($value, self::MAX_LENGTH);
        }

        return new Address($value);
    }
}
