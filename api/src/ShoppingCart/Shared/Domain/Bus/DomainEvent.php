<?php

namespace ShoppingCart\Shared\Domain\Bus;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

abstract readonly class DomainEvent
{
    public string $eventId;
    public DateTimeImmutable $occurredOn;

    public function __construct(public string $aggregateId)
    {
        $this->eventId = UuidUtils::random();
        $this->occurredOn = DateTimeUtils::now();
    }

    abstract public function attributes(): array;
}
