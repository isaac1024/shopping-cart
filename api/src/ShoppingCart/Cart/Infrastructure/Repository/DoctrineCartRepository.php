<?php

namespace ShoppingCart\Cart\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Cart\Domain\Cart;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Domain\Product;
use ShoppingCart\Shared\Domain\Models\CartId;

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
        $sql = "SELECT id, title, price FROM products WHERE id = :id";
        $productData = $this->entityManager->getConnection()->fetchAssociative($sql, ['id' => $productId]);
        if ($productData === false) {
            return null;
        }

        return Product::init($productData['id'], $productData['title'], $productData['price']);
    }
}
