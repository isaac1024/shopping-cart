<?php

namespace ShoppingCart\Shared\Domain\Models;

use DateTimeImmutable;

final readonly class Timestamps
{
    public function __construct(public DateTimeImmutable $createdAt, public DateTimeImmutable $updatedAt)
    {
    }

    public static function init(): Timestamps
    {
        $now = DateTimeUtils::now();
        return new Timestamps($now, $now);
    }

    public function update(): Timestamps
    {
        return new Timestamps($this->createdAt, DateTimeUtils::now());
    }
}
