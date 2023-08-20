<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class ValidAddress
{
    private const MAX_LENGTH = 255;

    public function __construct(private string $address)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->address !== trim($this->address)) {
            throw AddressException::nameWithWhitespaces($this->address);
        }

        if (empty($this->address)) {
            throw AddressException::emptyAddress();
        }

        if (strlen($this->address) > self::MAX_LENGTH) {
            throw AddressException::tooLong($this->address, self::MAX_LENGTH);
        }
    }

    public function create(): Address
    {
        return new Address($this->address);
    }
}
