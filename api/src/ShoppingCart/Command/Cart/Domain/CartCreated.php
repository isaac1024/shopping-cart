<?php

namespace ShoppingCart\Command\Cart\Domain;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Bus\DomainEvent;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;

final readonly class CartCreated extends DomainEvent
{
    public function __construct(
        string $cartId,
        private int $numberItems,
        private int $totalAmount,
        private array $productItems,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
    ) {
        parent::__construct($cartId);
    }

    public function type(): string
    {
        return 'shopping_cart.v1.cart.created';
    }

    public function attributes(): array
    {
        return [
            'numberItems' => $this->numberItems,
            'totalAmount' => $this->totalAmount,
            'productItems' => $this->productItems,
            'createdAt' => DateTimeUtils::format($this->createdAt),
            'updatedAt' => DateTimeUtils::format($this->updatedAt),
        ];
    }
}
