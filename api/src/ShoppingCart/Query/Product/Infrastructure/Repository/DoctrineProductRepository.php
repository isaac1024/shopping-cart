<?php

namespace ShoppingCart\Query\Product\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ShoppingCart\Query\Product\Domain\Product;
use ShoppingCart\Query\Product\Domain\ProductCollection;
use ShoppingCart\Query\Product\Domain\ProductRepository;

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
