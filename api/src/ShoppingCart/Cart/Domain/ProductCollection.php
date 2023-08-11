<?php

namespace ShoppingCart\Cart\Domain;

final readonly class ProductCollection
{
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->products = $products;
    }

    public static function init(): ProductCollection
    {
        return new ProductCollection();
    }

    public function toArray(): array
    {
        return array_map(fn (Product $product) => $product->toArray(), $this->products);
    }

    public function get(string $productId): ?Product
    {
        $products = array_filter($this->products, fn (Product $product) => $product->productId === $productId);
        if (count($products) === 0) {
            return null;
        }

        return $products[0];
    }

    public function add(Product $product): ProductCollection
    {
        if ($product->quantity === 0) {
            throw ProductCollectionException::zeroQuantity();
        }

        $productId = $product->productId;
        $products = array_filter($this->products, fn (Product $product) => $product->productId !== $productId);

        return new ProductCollection($product, ...$products);
    }

    public function totalQuantity(): int
    {
        return array_reduce($this->products, fn (int $quantity, Product $product) => $quantity + $product->quantity, 0);
    }

    public function totalAmount(): int
    {
        return array_reduce($this->products, fn (int $amount, Product $product) => $amount + $product->totalPrice, 0);
    }

    public function remove(string $productId): ProductCollection
    {
        return new ProductCollection(
            ...array_filter($this->products, fn (Product $product) => $product->productId !== $productId)
        );
    }
}
