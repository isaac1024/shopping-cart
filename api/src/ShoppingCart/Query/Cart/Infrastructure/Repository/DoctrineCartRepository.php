<?php

namespace ShoppingCart\Query\Cart\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Query\Cart\Domain\Cart;
use ShoppingCart\Query\Cart\Domain\CartRepository;

final readonly class DoctrineCartRepository implements CartRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function search(string $cartId): ?Cart
    {
        return $this->entityManager->getRepository(Cart::class)->find($cartId);
    }
}
