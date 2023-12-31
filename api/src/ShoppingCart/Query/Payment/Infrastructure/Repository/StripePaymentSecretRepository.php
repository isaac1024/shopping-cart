<?php

namespace ShoppingCart\Query\Payment\Infrastructure\Repository;

use ShoppingCart\Query\Payment\Domain\Payment;
use ShoppingCart\Query\Payment\Domain\PaymentSecretRepository;
use Stripe\StripeClient;

final readonly class StripePaymentSecretRepository implements PaymentSecretRepository
{
    private StripeClient $stripeClient;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripeClient = new StripeClient($stripeSecretKey);
    }

    /**
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     */
    public function getSecret(Payment $payment): string
    {
        $paymentIntent = $this->stripeClient->paymentIntents->create([
            'amount' => $payment->amount(),
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return $paymentIntent->client_secret;
    }
}
