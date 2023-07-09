<?php

namespace ShoppingCart\Order\Application;

use ShoppingCart\Order\Domain\Order;
use ShoppingCart\Order\Domain\OrderRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Bus\EventBus;

final readonly class OrderCreatorCommandHandler implements CommandHandler
{
    public function __construct(private OrderRepository $orderRepository, private EventBus $eventBus)
    {
    }

    public function dispatch(OrderCreatorCommand $command): void
    {
        Order::new(
            $command->orderId,
            $command->name,
            $command->address,
            $command->cartId,
            $command->productItems,
            $command->cardNumber,
            $command->cardValidDate,
            $command->cardCvv,
        )->save($this->orderRepository, $this->eventBus);
    }
}
