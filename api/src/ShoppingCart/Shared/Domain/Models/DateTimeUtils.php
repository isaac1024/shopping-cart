<?php

declare(strict_types=1);

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

final class DateTimeUtils
{
    private const DATABASE_FORMAT = 'Y-m-d h:i:s';

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

    public static function fromDatabase(string $dateTime): DateTimeImmutable
    {
        $datetime = DateTimeImmutable::createFromFormat(self::DATABASE_FORMAT, $dateTime);
        if ($datetime === false) {
            throw DateTimeUtilsException::invalidDateTimeFormat($dateTime, self::DATABASE_FORMAT);
        }

        return $datetime;
    }

    public static function toDatabase(DateTimeImmutable $dateTime): string
    {
        return $dateTime->format(self::DATABASE_FORMAT);
    }
}
