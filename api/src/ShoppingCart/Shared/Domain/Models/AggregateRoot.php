<?php

namespace ShoppingCart\Shared\Domain\Models;

use ShoppingCart\Shared\Domain\Bus\DomainEvent;
use ShoppingCart\Shared\Domain\Bus\EventBus;

abstract class AggregateRoot
{
    /** @var DomainEvent[] $events */
    private array $events = [];

    final protected function publishEvents(EventBus $eventBus): void
    {
        $eventBus->publish(...$this->events);
        $this->events = [];
    }

    final protected function registerNewEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
