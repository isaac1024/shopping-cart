<?php

namespace ShoppingCart\Tests\Query\Cart\Domain;

use ShoppingCart\Query\Cart\Domain\ProductCollection;

final class ProductCollectionOrderMother
{
    public static function make(int $numberProducts): ProductCollection
    {
        $products = [];
        for ($i = 0;$i < $numberProducts;$i++) {
            $products[] = ProductObjectMother::make();
        }

        return new ProductCollection(...$products);
    }
}
