<?php

namespace ShoppingCart\Order\Domain;

final readonly class TotalAmount
{
    public function __construct(public int $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value <= 0) {
            throw TotalAmountException::noAmount();
        }
    }
}
