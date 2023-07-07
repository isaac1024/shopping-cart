<?php

namespace ShoppingCart\Product\Application;

use Countable;
use IteratorAggregate;
use ShoppingCart\Product\Domain\Product;
use ShoppingCart\Product\Domain\ProductCollection;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, ProductResponse>
 */
final readonly class ProductsFinderQueryResponse implements Countable, IteratorAggregate
{
    public array $products;

    public function __construct(ProductResponse ...$products)
    {
        $this->products = $products;
    }

    public static function formProductCollection(ProductCollection $products): ProductsFinderQueryResponse
    {
        $productsResponse = array_map(
            fn (Product $product) => ProductResponse::fromProduct($product),
            $products->products
        );

        return new ProductsFinderQueryResponse(...$productsResponse);
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function getIterator(): Traversable
    {
        yield from $this->products;
    }
}
