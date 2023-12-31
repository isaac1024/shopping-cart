<?php

namespace ShoppingCart\Command\Cart\Domain;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\RepositoryModel;

final readonly class CartModel extends RepositoryModel
{
    public function __construct(
        public string $cartId,
        public int $numberItems,
        public int $totalAmount,
        public array $productItems,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        AggregateStatus $aggregateStatus,
    ) {
        parent::__construct($createdAt, $updatedAt, $aggregateStatus);
    }
}
