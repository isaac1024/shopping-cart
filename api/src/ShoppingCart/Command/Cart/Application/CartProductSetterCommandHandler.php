<?php

namespace ShoppingCart\Command\Cart\Application;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Domain\Bus\CommandHandler;
use ShoppingCart\Shared\Domain\Models\CartId;

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
