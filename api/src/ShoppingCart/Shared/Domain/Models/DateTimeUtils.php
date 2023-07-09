<?php

declare(strict_types=1);

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

final class DateTimeUtils
{
    public static function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
