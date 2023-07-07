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
        self::assertCount(0, $products);
    }

    public function testGetOneProduct(): void
    {
        $expectedProduct = ProductObjectMother::make();
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($expectedProduct);
        $em->flush();

        $products = $this->repository->all();
        self::assertEquals(new ProductCollection($expectedProduct), $products);
    }

    public function testGetTwoProducts(): void
    {
        $expectedProduct1 = ProductObjectMother::make();
        $expectedProduct2 = ProductObjectMother::make();
        $expectedProducts = new ProductCollection($expectedProduct1, $expectedProduct2);
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($expectedProduct1);
        $em->persist($expectedProduct2);
        $em->flush();

        $products = $this->repository->all();
        self::assertEqualsCanonicalizing($expectedProducts, $products);
    }
}
