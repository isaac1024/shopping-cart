<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;

final readonly class CartProductSetterCommandHandler implements CommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function dispatch(CartProductSetterCommand $command): void
    {
        $cart = $this->cartRepository->find(new CartId($command->cartId));
        if (!$cart) {
            throw NotFoundCartException::notFound($command->cartId);
        }

        $cart->updateProduct($command->productId, $command->quantity, $this->cartRepository)
            ->save($this->cartRepository);
    }
}
