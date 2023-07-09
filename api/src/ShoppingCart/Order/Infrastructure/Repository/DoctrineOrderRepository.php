<?php

namespace ShoppingCart\Order\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Order\Domain\Order;
use ShoppingCart\Order\Domain\OrderRepository;

final readonly class DoctrineOrderRepository implements OrderRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
