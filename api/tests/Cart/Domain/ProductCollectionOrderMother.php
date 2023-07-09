<?php

namespace ShoppingCart\Tests\Cart\Domain;

use ShoppingCart\Cart\Domain\ProductCollection;

final class ProductCollectionOrderMother
{
    public static function make(int $numberProducts): ProductCollection
    {
        $products = [];
        for ($i=0;$i<$numberProducts;$i++) {
            $products[] = ProductObjectMother::make();
        }

        return new ProductCollection(...$products);
    }
}
