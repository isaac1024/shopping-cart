<?php

namespace ShoppingCart\Order\Domain;

final readonly class Address
{
    private const MAX_LENGTH = 255;

    public function __construct(public string $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value !== trim($this->value)) {
            throw AddressException::nameWithWhitespaces($this->value);
        }

        if (empty($this->value)) {
            throw AddressException::emptyAddress();
        }

        if (strlen($this->value) > self::MAX_LENGTH) {
            throw AddressException::tooLong($this->value, self::MAX_LENGTH);
        }
    }
}
