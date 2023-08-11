<?php

namespace ShoppingCart\Tests\Query\Product\Infrastructure\Repository;

use ShoppingCart\Query\Product\Domain\ProductRepository;
use ShoppingCart\Query\Product\Infrastructure\Repository\DoctrineProductRepository;
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
        self::assertCount(7, $products->products());
    }
}
