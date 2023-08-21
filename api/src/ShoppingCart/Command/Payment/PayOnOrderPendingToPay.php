<?php

namespace ShoppingCart\Command\Payment;

use ShoppingCart\Shared\Domain\Bus\EventSubscriber;
use ShoppingCart\Shared\Domain\Logger;

final readonly class PayOnOrderPendingToPay implements EventSubscriber
{
    public function __construct(private Logger $logger)
    {
    }

    public function dispatch(OrderPendingToPay $event): void
    {
        $this->logger->info('Paying the order', [
            'orderId' => $event->aggregateId,
            'attributes' => $event->attributes(),
        ]);
    }
}
