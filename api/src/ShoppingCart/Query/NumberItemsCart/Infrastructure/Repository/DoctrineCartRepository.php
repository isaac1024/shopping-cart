<?php

namespace ShoppingCart\Query\NumberItemsCart\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Query\NumberItemsCart\Domain\Cart;
use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;

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
