<?php

namespace ShoppingCart\Command\Payment\Application;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Bus\Event;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;

final readonly class OrderCreated extends Event
{
    public function __construct(
        string $id,
        private string $name,
        private string $address,
        private string $cartId,
        private array $productItems,
        string $eventId,
        DateTimeImmutable $occurredOn,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromConsumer(array $eventData): static
    {
        return new OrderCreated(
            $eventData['data']['id'],
            $eventData['data']['attributes']['name'],
            $eventData['data']['attributes']['address'],
            $eventData['data']['attributes']['cartId'],
            $eventData['data']['attributes']['productItems'],
            $eventData['id'],
            DateTimeUtils::fromString($eventData['occurredOn']),
        );
    }

    public static function type(): string
    {
        return 'shopping_cart.payment.pay.shopping_cart.order.created';
    }

    public function attributes(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'cartId' => $this->cartId,
            'productItems' => $this->productItems,
        ];
    }
}
