<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class ValidName
{
    private const MAX_LENGTH = 180;

    public function __construct(private string $name)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->name !== trim($this->name)) {
            throw NameException::nameWithWhitespaces($this->name);
        }

        if (empty($this->name)) {
            throw NameException::emptyName();
        }

        if (strlen($this->name) > self::MAX_LENGTH) {
            throw NameException::tooLong($this->name, self::MAX_LENGTH);
        }
    }

    public function create(): Name
    {
        return new Name($this->name);
    }
}
