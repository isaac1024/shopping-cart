<?php

namespace ShoppingCart\Command\Cart\Domain;

final class Product
{
    public function __construct(
        public string $productId,
        public string $title,
        public string $photo,
        public int $unitPrice,
        public int $quantity,
        public int $totalPrice
    ) {
    }

    public static function init(string $productId, string $title, string $photo, int $unitPrice): Product
    {
        return new Product($productId, $title, $photo, $unitPrice, 0, 0);
    }

    public function toArray(): array
    {
        return [
            'productId' => $this->productId,
            'title' => $this->title,
            'photo' => $this->photo,
            'unitPrice' => $this->unitPrice,
            'quantity' => $this->quantity,
            'totalPrice' => $this->totalPrice,
        ];
    }

    public function addQuantity(int $quantity): Product
    {
        $newQuantity = $this->quantity + $quantity;

        if ($newQuantity < 0) {
            throw ProductException::negativeQuantity();
        }

        $totalPrice = $this->calculateNewTotalPrice($newQuantity);
        return new Product($this->productId, $this->title, $this->photo, $this->unitPrice, $newQuantity, $totalPrice);
    }

    private function calculateNewTotalPrice(int $quantity): int
    {
        return $this->unitPrice * $quantity;
    }
}
