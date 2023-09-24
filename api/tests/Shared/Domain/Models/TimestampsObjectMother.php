<?php

namespace ShoppingCart\Tests\Shared\Domain\Models;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final class TimestampsObjectMother
{
    public static function make(
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?AggregateStatus   $aggregateStatus = null,
    ): Timestamps {
        $now = DateTimeUtils::now();
        return new Timestamps(
            $createdAt ?? $now,
            $updatedAt ?? $now,
            $aggregateStatus ?? AggregateStatus::LOADED,
        );
    }
}
