<?php

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

abstract readonly class RepositoryModel
{
    public function __construct(
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public AggregateStatus $aggregateStatus,
    ) {
    }
}
