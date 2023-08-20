<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class ValidProduct
{
    public function __construct(
        private string $productId,
        private string $title,
        private int $unitPrice,
        private int $quantity,
        private int $totalPrice,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->quantity <= 0) {
            throw ProductException::noQuantity();
        }

        if ($this->unitPrice <= 0) {
            throw ProductException::noPrice();
        }

        if ($this->totalPrice !== $this->unitPrice * $this->quantity) {
            throw ProductException::totalPriceNotValid();
        }
    }

    public function create(): Product
    {
        return new Product(
            $this->productId,
            $this->title,
            $this->unitPrice,
            $this->quantity,
            $this->totalPrice,
        );
    }
}
