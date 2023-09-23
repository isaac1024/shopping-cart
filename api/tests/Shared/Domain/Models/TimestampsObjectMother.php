<?php

namespace Shared\Domain\Models;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final class TimestampsObjectMother
{
    public static function make(?DateTimeImmutable $createdAt = null, ?DateTimeImmutable $updatedAt = null): Timestamps
    {
        $now = DateTimeUtils::now();
        return new Timestamps($createdAt ?? $now, $updatedAt ?? $now);
    }
}
