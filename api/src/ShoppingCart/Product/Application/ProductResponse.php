<?php

namespace ShoppingCart\Product\Application;

use ShoppingCart\Product\Domain\Product;

final readonly class ProductResponse
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $photo,
        public int $price,
    ) {
    }

    public static function fromProduct(Product $product): ProductResponse
    {
        return new ProductResponse(
            $product->id,
            $product->title,
            $product->description,
            $product->photo,
            $product->price
        );
    }
}
