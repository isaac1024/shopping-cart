<?php

namespace ShoppingCart\Query\Payment\Domain;

interface PaymentSecretRepository
{
    public function getSecret(Payment $payment): string;
}