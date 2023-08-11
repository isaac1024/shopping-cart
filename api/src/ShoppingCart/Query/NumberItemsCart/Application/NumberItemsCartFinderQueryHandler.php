<?php

namespace ShoppingCart\Query\NumberItemsCart\Application;

use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\QueryHandler;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;

final readonly class NumberItemsCartFinderQueryHandler implements QueryHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function ask(NumberItemsCartFinderQuery $query): NumberItemsCartFinderResponse
    {
        $cart = $this->cartRepository->search($query->id);
        if (!$cart) {
            throw NotFoundCartException::notFound($query->id);
        }

        return NumberItemsCartFinderResponse::fromCart($cart);
    }
}
