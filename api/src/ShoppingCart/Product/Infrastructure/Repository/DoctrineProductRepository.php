<?php

namespace ShoppingCart\Product\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Product\Domain\Product;
use ShoppingCart\Product\Domain\ProductCollection;
use ShoppingCart\Product\Domain\ProductRepository;

final readonly class DoctrineProductRepository implements ProductRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function all(): ProductCollection
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return new ProductCollection(...$products);
    }
}
