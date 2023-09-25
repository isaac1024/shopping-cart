<?php

namespace ShoppingCart\Event\MercurePublisher\Domain;

final readonly class Cart
{
    public function __construct(
        private string $cartId,
        private int $numberItems,
    ) {
    }

    public function publish(Publisher $publisher): void
    {
        $publisher->publish($this->cartId, $this->toJson());
    }

    private function toJson(): string
    {
        return json_encode(['cartId' => $this->cartId, 'numberItems' => $this->numberItems]);
    }
}
