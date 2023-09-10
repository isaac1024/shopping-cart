<?php

namespace ShoppingCart\Query\Payment\Application;

use ShoppingCart\Shared\Domain\Bus\Query;

final readonly class PaymentSecretQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
