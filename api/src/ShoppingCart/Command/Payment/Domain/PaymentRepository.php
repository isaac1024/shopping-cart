<?php

namespace ShoppingCart\Command\Payment\Domain;

interface PaymentRepository
{
    public function createCheckout(): string;
}
