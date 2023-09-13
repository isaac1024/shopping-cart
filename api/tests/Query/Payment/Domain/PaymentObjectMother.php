<?php

namespace ShoppingCart\Tests\Query\Payment\Domain;

use Faker\Factory;
use ShoppingCart\Query\Payment\Application\PaymentSecretQuery;
use ShoppingCart\Query\Payment\Domain\Payment;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class PaymentObjectMother
{
    public static function make(?string $id = null, ?int $amount = null): Payment
    {
        $faker = Factory::create();
        return new Payment($id ?? UuidUtils::random(), $amount ?? $faker->numberBetween(100, 10000));
    }

    public static function fromPaymentSecretQuery(PaymentSecretQuery $query): Payment
    {
        return PaymentObjectMother::make($query->id);
    }
}
