<?php

namespace ShoppingCart\Tests\Shared\Domain\Models;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final class TimestampsObjectMother
{
    public static function make(
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DatabaseStatus $databaseStatus = null,
    ): Timestamps {
        $now = DateTimeUtils::now();
        return new Timestamps(
            $createdAt ?? $now,
            $updatedAt ?? $now,
            $databaseStatus ?? DatabaseStatus::DATABASE_LOADED,
        );
    }
}
