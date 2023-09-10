<?php

namespace ShoppingCart\Query\Payment\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Query\Payment\Domain\Payment;
use ShoppingCart\Query\Payment\Domain\PaymentRepository;

final readonly class DoctrinePaymentRepository implements PaymentRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function find(string $id): ?Payment
    {
        $payment = $this->connection->fetchAssociative("SELECT total_amount FROM orders WHERE id = :id", ['id' => $id]);
        return $payment ? new Payment($id, $payment['total_amount']) : null;
    }
}
