<?php

namespace ShoppingCart\Tests\Product\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Product\Domain\ProductCollection;
use ShoppingCart\Product\Domain\ProductRepository;
use ShoppingCart\Product\Infrastructure\Repository\DoctrineProductRepository;
use ShoppingCart\Tests\Product\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrineProductRepositoryTest extends IntegrationTestCase
{
    private ProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrineProductRepository::class);
    }

    public function testNotGetProducts(): void
    {
        $products = $this->repository->all();
        self::assertCount(7, $products);
    }
}
