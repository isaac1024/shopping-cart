<?php

namespace ShoppingCart\Query\Payment\Domain;

final readonly class Payment
{
    public function __construct(
        private string $id,
        private int $amount,
    ) {
    }

    public function secret(PaymentSecretRepository $paymentSecretRepository): string
    {
        return $paymentSecretRepository->getSecret($this);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
