<?php

namespace ShoppingCart\Command\Cart\Application;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;

final readonly class CartProductRemoverCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function dispatch(CartProductRemoverCommand $command): void
    {
        $cart = $this->cartRepository->search($command->cartId);
        if (!$cart) {
            throw NotFoundCartException::notFound($command->cartId);
        }

        $cart->removeProduct($command->productId)->save($this->cartRepository);
    }
}
