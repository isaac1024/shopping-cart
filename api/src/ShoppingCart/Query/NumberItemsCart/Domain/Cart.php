<?php

namespace ShoppingCart\Query\NumberItemsCart\Domain;

final readonly class Cart
{
    public function __construct(
        private string $id,
        private int $numberItems,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function numberItems(): int
    {
        return $this->numberItems;
    }
}
