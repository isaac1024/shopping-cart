<?php

namespace ShoppingCart\Command\Order\Application;

use ShoppingCart\Command\Order\Domain\Order;
use ShoppingCart\Command\Order\Domain\OrderRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;

final readonly class OrderCreatorCommandHandler implements CommandHandler
{
    public function __construct(private OrderRepository $orderRepository)
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
        )->save($this->orderRepository);
    }
}
