<?php

namespace ShoppingCart\Query\Cart\Domain;

final readonly class Product
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
}
