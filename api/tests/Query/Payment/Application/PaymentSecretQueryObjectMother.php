<?php

namespace ShoppingCart\Tests\Query\Payment\Application;

use ShoppingCart\Query\Payment\Application\PaymentSecretQuery;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class PaymentSecretQueryObjectMother
{
    public static function make(?string $id = null): PaymentSecretQuery
    {
        return new PaymentSecretQuery($id ?? UuidUtils::random());
    }
}
