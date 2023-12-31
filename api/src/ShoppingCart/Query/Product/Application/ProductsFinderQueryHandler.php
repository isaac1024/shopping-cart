<?php

namespace ShoppingCart\Query\Product\Application;

use ShoppingCart\Query\Product\Domain\ProductRepository;
use ShoppingCart\Shared\Domain\Bus\QueryHandler;

final readonly class ProductsFinderQueryHandler implements QueryHandler
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function ask(ProductsFinderQuery $query): ProductsFinderQueryResponse
    {
        $products = $this->productRepository->all();
        return ProductsFinderQueryResponse::formProductCollection($products);
    }
}
