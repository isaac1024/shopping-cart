<?php

namespace ShoppingCart\Cart\Application;

use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Domain\Bus\QueryHandler;

final readonly class CartFinderQueryHandler implements QueryHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function ask(CartFinderQuery $query): CartFinderResponse
    {
        $cart = $this->cartRepository->find(new CartId($query->id));
        if (!$cart) {
            throw NotFoundCartException::notFound($query->id);
        }

        return new CartFinderResponse(
            $cart->getCartId(),
            $cart->getNumberItems(),
            $cart->getTotalAmount(),
            $cart->getProductItems()
        );
    }
}
