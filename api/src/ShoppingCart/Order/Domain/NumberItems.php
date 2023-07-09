<?php

namespace ShoppingCart\Order\Domain;

final readonly class NumberItems
{
    public function __construct(public int $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value <= 0) {
            throw NumberItemsException::orderWithoutItems();
        }
    }
}
