<?php

namespace ShoppingCart\Command\Cart\Application;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;

final readonly class CartProductSetterCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository, private EventBus $eventBus)
    {
    }

    public function dispatch(CartProductSetterCommand $command): void
    {
        $cart = $this->cartRepository->search($command->cartId);
        if (!$cart) {
            throw NotFoundCartException::notFound($command->cartId);
        }

        $cart->updateProduct($command->productId, $command->quantity, $this->cartRepository)
            ->save($this->cartRepository, $this->eventBus);
    }
}
