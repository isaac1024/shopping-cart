<?php

namespace ShoppingCart\Cart\Domain;

final class Product
{
    public function __construct(
        public string $productId,
        public string $title,
        public int $unitPrice,
        public int $quantity,
        public int $totalPrice
    ) {
        $this->validate();
    }

    public static function init(string $productId, string $title, int $unitPrice): Product
    {
        return new Product($productId, $title, $unitPrice, 0, 0);
    }

    public function updateQuantity(int $quantity): Product
    {
        $totalPrice = $this->calculateNewTotalPrice($quantity);
        return new Product($this->productId, $this->title, $this->unitPrice, $quantity, $totalPrice);
    }

    private function validate(): void
    {
        if ($this->quantity < 0) {
            throw ProductException::negativeQuantity();
        }

        if ($this->unitPrice < 0) {
            throw NegativeProductPriceException::negativePrice();
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
