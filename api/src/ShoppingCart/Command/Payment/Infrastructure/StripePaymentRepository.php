<?php

namespace ShoppingCart\Command\Payment\Infrastructure;

use ShoppingCart\Command\Payment\Domain\PaymentRepository;
use Stripe\StripeClient;

final readonly class StripePaymentRepository implements PaymentRepository
{
    private StripeClient $stripeClient;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripeClient = new StripeClient($stripeSecretKey);
    }

    public function createCheckout(): string
    {
        $paymentIntent = $this->stripeClient->paymentIntents->create([
            'amount' => 0,
            'currency' => 'eur',
            'automatic_payment_methods' => ['endabled' => true],
        ]);

        return $paymentIntent->client_secret;
    }
}
