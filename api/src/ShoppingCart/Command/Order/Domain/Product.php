<?php

namespace ShoppingCart\Command\Order\Domain;

final class Product
{
    public function __construct(
        public string $productId,
        public string $title,
        public int $unitPrice,
        public int $quantity,
        public int $totalPrice,
    ) {
    }

    public static function create(
        string $productId,
        string $title,
        int $unitPrice,
        int $quantity,
        int $totalPrice,
    ): Product {
        if ($quantity <= 0) {
            throw ProductException::noQuantity();
        }

        if ($unitPrice <= 0) {
            throw ProductException::noPrice();
        }

        if ($totalPrice !== $unitPrice * $quantity) {
            throw ProductException::totalPriceNotValid();
        }

        return new Product($productId, $title, $unitPrice, $quantity, $totalPrice);
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
}
