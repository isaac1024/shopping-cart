<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\Bus\DomainEvent;

final readonly class OrderPendingToPay extends DomainEvent
{
    public function __construct(
        string $id,
        private string $cardNumber,
        private string $cardValidDate,
        private string $cardCvv
    ) {
        parent::__construct($id);
    }

    public function type(): string
    {
        return 'soppingCart.order.orderPendingToPay';
    }

    public function attributes(): array
    {
        return [
            'cardNumber' => $this->cardNumber,
            'cardValidDate' => $this->cardValidDate,
            'cardCvv' => $this->cardCvv,
        ];
    }
}