<?php

namespace ShoppingCart\Command\Cart\Application;

use ShoppingCart\Command\Cart\Domain\Cart;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Bus\EventBus;

final readonly class CartCreatorCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository, private EventBus $eventBus)
    {
    }

    public function dispatch(CartCreatorCommand $command): void
    {
        Cart::new($command->cartId)->save($this->cartRepository, $this->eventBus);
    }
}
