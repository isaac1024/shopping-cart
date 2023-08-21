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

    public static function format(DateTimeImmutable $dateTime): string
    {
        return $dateTime->format(DateTimeImmutable::ATOM);
    }

    public static function fromString(string $dateTime): DateTimeImmutable
    {
        $datetime = DateTimeImmutable::createFromFormat(DateTimeImmutable::ATOM, $dateTime);
        if ($datetime === false) {
            throw DateTimeUtilsException::invalidDateTimeFormat($dateTime, DateTimeImmutable::ATOM);
        }

        return $datetime;
    }
}
