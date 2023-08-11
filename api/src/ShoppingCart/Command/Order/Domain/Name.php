<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class Name
{
    private const MAX_LENGTH = 180;

    public function __construct(public string $value)
    {
    }

    public static function create(string $value): Name
    {
        if ($value !== trim($value)) {
            throw NameException::nameWithWhitespaces($value);
        }

        if (empty($value)) {
            throw NameException::emptyName();
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw NameException::tooLong($value, self::MAX_LENGTH);
        }

        return new Name($value);
    }
}
