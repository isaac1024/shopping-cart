<?php

namespace ShoppingCart\Command\Payment;

use DateTimeImmutable;
use ShoppingCart\Shared\Domain\Bus\Event;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;

final readonly class OrderPendingToPay extends Event
{
    public function __construct(
        string $id,
        private string $name,
        private int $totalAmount,
        private string $cardNumber,
        private string $cardValidDate,
        private string $cardCvv,
        string $eventId,
        DateTimeImmutable $occurredOn,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromConsumer(array $eventData): static
    {
        return new OrderPendingToPay(
            $eventData['data']['id'],
            $eventData['data']['attributes']['name'],
            $eventData['data']['attributes']['totalAmount'],
            $eventData['data']['attributes']['cardNumber'],
            $eventData['data']['attributes']['cardValidDate'],
            $eventData['data']['attributes']['cardCvv'],
            $eventData['id'],
            DateTimeUtils::fromString($eventData['occurredOn']),
        );
    }

    public static function type(): string
    {
        return 'shopping_cart.payment.pay.shopping_cart.order.pending_to_pay';
    }

    public function attributes(): array
    {
        return [
            'name' => $this->name,
            'totalAmount' => $this->totalAmount,
            'cardNumber' => $this->cardNumber,
            'cardValidDate' => $this->cardValidDate,
            'cardCvv' => $this->cardCvv,
        ];
    }
}
