<?php

namespace ShoppingCart\Query\Payment\Domain;

interface PaymentRepository
{
    public function find(string $id): ?Payment;
}
