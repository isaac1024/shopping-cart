<?php

namespace ShoppingCart\Command\Order\Infrastructure\Request;

final readonly class OrderCreatorRequest
{
    public function __construct(
        public string $cartId,
        public string $name,
        public string $address,
        public CardRequest $card
    ) {
    }
}
