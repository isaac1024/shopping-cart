<?php

namespace ShoppingCart\Event\MercurePublisher\Application;

use DateTimeImmutable;
use ShoppingCart\Event\MercurePublisher\Domain\Cart;
use ShoppingCart\Shared\Domain\Bus\Event;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;

final readonly class CartUpdated extends Event
{
    protected function __construct(
        string $cartId,
        private int $numberItems,
        private int $totalAmount,
        private array $productItems,
        private DateTimeImmutable $createdAt,
        private DateTimeImmutable $updatedAt,
        string $eventId,
        DateTimeImmutable $occurredOn,
    ) {
        parent::__construct($cartId, $eventId, $occurredOn);
    }

    public static function fromConsumer(array $eventData): static
    {
        return new CartUpdated(
            $eventData['data']['id'],
            $eventData['data']['attributes']['numberItems'],
            $eventData['data']['attributes']['totalAmount'],
            $eventData['data']['attributes']['productItems'],
            DateTimeUtils::fromString($eventData['data']['attributes']['createdAt']),
            DateTimeUtils::fromString($eventData['data']['attributes']['updatedAt']),
            $eventData['id'],
            DateTimeUtils::fromString($eventData['occurredOn']),
        );
    }

    public static function type(): string
    {
        return 'shopping_cart.mercury_publisher.notify_on_cart_updated.shopping_cart.v1.cart.updated';
    }

    public function attributes(): array
    {
        return [
            'numberItems' => $this->numberItems,
            'totalAmount' => $this->totalAmount,
            'productItems' => $this->productItems,
            'createdAt' => DateTimeUtils::format($this->createdAt),
            'updatedAt' => DateTimeUtils::format($this->updatedAt),
        ];
    }

    public function toCart(): Cart
    {
        return new Cart($this->aggregateId, $this->numberItems);
    }
}
