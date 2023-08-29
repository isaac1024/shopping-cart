<?php

namespace ShoppingCart\Command\Payment\Application;

use ShoppingCart\Shared\Domain\Bus\EventSubscriber;
use ShoppingCart\Shared\Domain\Logger;

final readonly class PayOnOrderCreated implements EventSubscriber
{
    public function __construct(private Logger $logger)
    {
    }

    public function dispatch(OrderCreated $event): void
    {
        $this->logger->info('Paying the order', [
            'orderId' => $event->aggregateId,
            'attributes' => $event->attributes(),
        ]);
    }
}
