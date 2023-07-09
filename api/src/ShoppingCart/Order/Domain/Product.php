<?php

namespace ShoppingCart\Order\Domain;

final class Product
{
    public function __construct(
        public string $productId,
        public string $title,
        public int $unitPrice,
        public int $quantity,
        public int $totalPrice,
    ) {
        $this->validate();
    }

    public function toArray(): array
    {
        return [
            'productId' => $this->productId,
            'title' => $this->title,
            'unitPrice' => $this->unitPrice,
            'quantity' => $this->quantity,
            'totalPrice' => $this->totalPrice,
        ];
    }

    private function validate(): void
    {
        if ($this->quantity <= 0) {
            throw ProductException::noQuantity();
        }

        if ($this->unitPrice <= 0) {
            throw ProductException::noPrice();
        }

        $totalPrice = $this->calculateNewTotalPrice($this->quantity);
        if ($totalPrice !== $this->totalPrice) {
            throw ProductException::totalPriceNotValid();
        }
    }

    private function calculateNewTotalPrice(int $quantity): int
    {
        return $this->unitPrice * $quantity;
    }
}
