<?php

namespace ShoppingCart\Event\MercurePublisher\Infrastructure;

use ShoppingCart\Event\MercurePublisher\Domain\Publisher;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

final readonly class MercurePublisher implements Publisher
{
    private const BASE_TOPIC = "shopping_cart.v1.cart.%s.%s";

    public function __construct(private HubInterface $hub)
    {
    }

    public function publish(string $cartId, string $data): void
    {
        $this->hub->publish(new Update(sprintf(self::BASE_TOPIC, 'updated', $cartId), $data));
    }
}
