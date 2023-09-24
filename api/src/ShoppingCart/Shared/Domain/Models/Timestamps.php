<?php

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

final readonly class Timestamps
{
    public function __construct(
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public AggregateStatus $aggregateStatus
    ) {
    }

    public static function fromDatabase(string $createdAt, string $updatedAt): Timestamps
    {
        return new Timestamps(
            DateTimeUtils::fromDatabase($createdAt),
            DateTimeUtils::fromDatabase($updatedAt),
            AggregateStatus::LOADED
        );
    }

    public static function init(): Timestamps
    {
        $now = DateTimeUtils::now();
        return new Timestamps($now, $now, AggregateStatus::CREATED);
    }

    public function update(): Timestamps
    {
        return new Timestamps($this->createdAt, DateTimeUtils::now(), AggregateStatus::UPDATED);
    }
}
