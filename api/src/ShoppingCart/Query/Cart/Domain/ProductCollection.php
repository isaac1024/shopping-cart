<?php

namespace ShoppingCart\Query\Cart\Domain;

final readonly class ProductCollection
{
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public function toArray(): array
    {
        return array_map(fn (Product $product) => $product->toArray(), $this->products);
    }

    public function totalQuantity(): int
    {
        return array_reduce($this->products, fn (int $quantity, Product $product) => $quantity + $product->quantity, 0);
    }

    public function totalAmount(): int
    {
        return array_reduce($this->products, fn (int $amount, Product $product) => $amount + $product->totalPrice, 0);
    }
}
