<?php

namespace ShoppingCart\Tests\Query\Payment\Application;

use Faker\Factory;
use ShoppingCart\Query\Payment\Application\PaymentSecretQueryResponse;

final class PaymentSecretQueryResponseObjectMother
{
    public static function make(?string $paymentSecret = null): PaymentSecretQueryResponse
    {
        $faker = Factory::create();
        return new PaymentSecretQueryResponse($paymentSecret ?? $faker->regexify('/[0-9a-f]{20,30}/'));
    }
}
