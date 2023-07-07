<?php

namespace ShoppingCart\Product\Application;

use ShoppingCart\Product\Domain\ProductRepository;

final readonly class ProductsFinderQueryHandler
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
