<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Cart\Domain\Cart;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;

final readonly class CartCreatorCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function dispatch(CartCreatorCommand $command): void
    {
        Cart::new($command->cartId)->save($this->cartRepository);
    }
}
