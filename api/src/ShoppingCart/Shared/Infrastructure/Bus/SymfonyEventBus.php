<?php

namespace ShoppingCart\Shared\Infrastructure\Bus;

use ShoppingCart\Shared\Domain\Bus\DomainEvent;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SymfonyEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
