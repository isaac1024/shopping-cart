<?php

namespace ShoppingCart\Query\Payment\Application;

final readonly class PaymentSecretQueryResponse
{
    public function __construct(public string $paymentSecret)
    {
    }
}