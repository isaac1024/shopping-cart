<?php

namespace ShoppingCart\Query\Product\Application;

use ShoppingCart\Query\Product\Domain\Product;
use ShoppingCart\Query\Product\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Bus\QueryResponse;

final readonly class ProductsFinderQueryResponse implements QueryResponse
{
    public array $products;

    public function __construct(ProductResponse ...$products)
    {
        $this->products = $products;
    }

    public static function formProductCollection(ProductCollection $productCollection): ProductsFinderQueryResponse
    {
        $productsResponse = array_map(
            fn (Product $product) => ProductResponse::fromProduct($product),
            $productCollection->products()
        );

        return new ProductsFinderQueryResponse(...$productsResponse);
    }
}
