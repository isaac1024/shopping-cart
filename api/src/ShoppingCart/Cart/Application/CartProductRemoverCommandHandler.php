<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Models\CartId;

class CartProductRemoverCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function dispatch(CartProductRemoverCommand $command): void
    {
        $cart = $this->cartRepository->find(new CartId($command->cartId));
        if (!$cart) {
            throw NotFoundCartException::notFound($command->cartId);
        }

        $cart->removeProduct($command->productId)
            ->save($this->cartRepository);
    }
}
