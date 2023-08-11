<?php

namespace ShoppingCart\Query\Product\Domain;

final readonly class ProductCollection
{
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public function products(): array
    {
        return $this->products;
    }
}
