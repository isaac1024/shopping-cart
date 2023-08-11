<?php

namespace ShoppingCart\Query\Cart\Application;

use ShoppingCart\Query\Cart\Domain\CartRepository;
use ShoppingCart\Query\Cart\Domain\NotFoundCartException;
use ShoppingCart\Shared\Domain\Bus\QueryHandler;
use ShoppingCart\Shared\Domain\Models\CartId;

final readonly class CartFinderQueryHandler implements QueryHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function ask(CartFinderQuery $query): CartFinderResponse
    {
        $cart = $this->cartRepository->search(new CartId($query->id));
        if (!$cart) {
            throw NotFoundCartException::notFound($query->id);
        }

        return CartFinderResponse::fromCart($cart);
    }
}
