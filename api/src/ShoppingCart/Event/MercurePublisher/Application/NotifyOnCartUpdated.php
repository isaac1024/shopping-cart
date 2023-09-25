<?php

namespace ShoppingCart\Event\MercurePublisher\Application;

use ShoppingCart\Event\MercurePublisher\Domain\Publisher;
use ShoppingCart\Shared\Domain\Bus\EventSubscriber;

final readonly class NotifyOnCartUpdated implements EventSubscriber
{
    public function __construct(private Publisher $publisher)
    {
    }

    public function dispatch(CartUpdated $event): void
    {
        $event->toCart()->publish($this->publisher);
    }
}
