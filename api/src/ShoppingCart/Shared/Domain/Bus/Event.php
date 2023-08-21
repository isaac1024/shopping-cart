<?php

namespace ShoppingCart\Shared\Domain\Bus;

use DateTimeImmutable;

abstract readonly class Event
{
    protected function __construct(
        public string $aggregateId,
        public string $eventId,
        public DateTimeImmutable $occurredOn,
    ) {
    }

    abstract public static function fromConsumer(array $eventData): static;

    abstract public static function type(): string;

    abstract public function attributes(): array;
}
