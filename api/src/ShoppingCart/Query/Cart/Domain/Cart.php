<?php

namespace ShoppingCart\Query\Cart\Domain;

final readonly class Cart
{
    public function __construct(
        private string $id,
        private int $numberItems,
        private int $totalAmount,
        private ProductCollection $productItems,
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

    public function totalAmount(): int
    {
        return $this->totalAmount;
    }

    public function productItems(): array
    {
        return $this->productItems->toArray();
    }
}
