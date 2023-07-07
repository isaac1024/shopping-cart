<?php

namespace ShoppingCart\Tests\Product\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Product\Application\ProductResponse;
use ShoppingCart\Product\Application\ProductsFinderQuery;
use ShoppingCart\Product\Application\ProductsFinderQueryHandler;
use ShoppingCart\Product\Application\ProductsFinderQueryResponse;
use ShoppingCart\Product\Domain\ProductCollection;
use ShoppingCart\Product\Domain\ProductRepository;
use ShoppingCart\Tests\Product\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class ProductsFinderQueryHandlerTest extends UnitTestCase
{
    private ProductsFinderQueryHandler $productsFinderQueryHandler;
    private ProductRepository&MockObject $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $this->productsFinderQueryHandler = new ProductsFinderQueryHandler($this->productRepository);
    }

    public function testRepositoryReturnEmptyCollection(): void
    {
        $query = new ProductsFinderQuery();

        $this->productRepository->expects($this->once())
            ->method('all')
            ->withAnyParameters()
            ->willReturn(new ProductCollection());

        $response = $this->productsFinderQueryHandler->ask($query);
        self::assertCount(0, $response);
    }

    public function testRepositoryReturnOneProduct(): void
    {
        $query = new ProductsFinderQuery();

        $product = ProductObjectMother::make();
        $expectedResponse = new ProductsFinderQueryResponse(ProductResponse::fromProduct($product));

        $this->productRepository->expects($this->once())
            ->method('all')
            ->withAnyParameters()
            ->willReturn(new ProductCollection($product));

        $response = $this->productsFinderQueryHandler->ask($query);
        self::assertEquals($expectedResponse, $response);
    }

    public function testRepositoryReturnTwoProducts(): void
    {
        $query = new ProductsFinderQuery();

        $product1 = ProductObjectMother::make();
        $product2 = ProductObjectMother::make();
        $expectedResponse = new ProductsFinderQueryResponse(
            ProductResponse::fromProduct($product1),
            ProductResponse::fromProduct($product2),
        );

        $this->productRepository->expects($this->once())
            ->method('all')
            ->withAnyParameters()
            ->willReturn(new ProductCollection($product1, $product2));

        $response = $this->productsFinderQueryHandler->ask($query);
        self::assertEquals($expectedResponse, $response);
    }
}
