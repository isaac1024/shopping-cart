<?php

namespace ShoppingCart\Cart\Domain;

final readonly class TotalAmount
{
    public function __construct(public int $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->value < 0) {
            throw TotalAmountException::negativeAmount();
        }
    }

    public static function init(): TotalAmount
    {
        return new TotalAmount(0);
    }
}
