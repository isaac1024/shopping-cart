<?php

namespace ShoppingCart\Cart\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Cart\Domain\Cart;
use ShoppingCart\Cart\Domain\CartId;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\Product;

final readonly class DoctrineCartRepository implements CartRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Cart $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function find(CartId $cartId): ?Cart
    {
        return $this->entityManager->getRepository(Cart::class)->find($cartId->value);
    }

    public function findProduct(string $productId): ?Product
    {
        // TODO: Implement findProduct() method.
        return null;
    }
}
