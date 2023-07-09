<?php

namespace ShoppingCart\Order\Domain;

final readonly class Name
{
    private const MAX_LENGTH = 180;

    public function __construct(public string $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value !== trim($this->value)) {
            throw NameException::nameWithWhitespaces($this->value);
        }

        if (empty($this->value)) {
            throw NameException::emptyName();
        }

        if (strlen($this->value) > self::MAX_LENGTH) {
            throw NameException::tooLong($this->value, self::MAX_LENGTH);
        }
    }
}