<?php

namespace ShoppingCart\Command\Order\Domain;

use ShoppingCart\Shared\Domain\Bus\DomainEvent;

final readonly class OrderPendingToPay extends DomainEvent
{
    public function __construct(
        string $id,
        private string $name,
        private int $totalAmount,
        private string $cardNumber,
        private string $cardValidDate,
        private string $cardCvv,
    ) {
        parent::__construct($id);
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
