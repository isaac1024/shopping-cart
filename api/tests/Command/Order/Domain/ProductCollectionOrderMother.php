<?php

namespace ShoppingCart\Tests\Command\Order\Domain;

use ShoppingCart\Command\Order\Domain\ProductCollection;

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
