<?php

namespace ShoppingCart\Query\Payment\Application;

use ShoppingCart\Shared\Domain\Bus\QueryResponse;

final readonly class PaymentSecretQueryResponse implements QueryResponse
{
    public function __construct(public string $paymentSecret)
    {
    }
}
