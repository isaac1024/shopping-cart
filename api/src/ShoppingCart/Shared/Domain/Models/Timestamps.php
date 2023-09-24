<?php

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

final readonly class Timestamps
{
    public function __construct(
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
        public DatabaseStatus $databaseStatus
    ) {
    }

    public static function fromDatabase(string $createdAt, string $updatedAt): Timestamps
    {
        return new Timestamps(
            DateTimeUtils::fromDatabase($createdAt),
            DateTimeUtils::fromDatabase($updatedAt),
            DatabaseStatus::DATABASE_LOADED
        );
    }

    public static function init(): Timestamps
    {
        $now = DateTimeUtils::now();
        return new Timestamps($now, $now, DatabaseStatus::CREATED);
    }

    public function update(): Timestamps
    {
        return new Timestamps($this->createdAt, DateTimeUtils::now(), DatabaseStatus::UPDATED);
    }
}
