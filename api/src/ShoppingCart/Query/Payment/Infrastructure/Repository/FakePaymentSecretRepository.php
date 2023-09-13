<?php

namespace ShoppingCart\Query\Payment\Infrastructure\Repository;

use Faker\Factory;
use Faker\Generator;
use ShoppingCart\Query\Payment\Domain\Payment;
use ShoppingCart\Query\Payment\Domain\PaymentSecretRepository;

final readonly class FakePaymentSecretRepository implements PaymentSecretRepository
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getSecret(Payment $payment): string
    {
        return $this->faker->regexify('/[0-9a-f]{20, 30}/');
    }
}
