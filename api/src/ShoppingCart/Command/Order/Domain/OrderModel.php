<?php

namespace ShoppingCart\Command\Order\Domain;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\RepositoryModel;

final readonly class OrderModel extends RepositoryModel
{
    public function __construct(
        public string $orderId,
        public string $status,
        public string $name,
        public string $address,
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
