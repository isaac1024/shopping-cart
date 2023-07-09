<?php

namespace ShoppingCart\Tests\Order\Domain;

use ShoppingCart\Order\Domain\ProductCollection;

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
