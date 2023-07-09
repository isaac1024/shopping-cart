<?php

namespace ShoppingCart\Order\Domain;

final readonly class ProductCollection
{
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->validate($products);
        $this->products = $products;
    }

    public function toArray(): array
    {
        return array_map(fn (Product $product) => $product->toArray(), $this->products);
    }

    private function validate(array $products): void
    {
        $productIds = [];
        /** @var Product $product */
        foreach ($products as $product) {
            if (in_array($product->productId, $productIds, true)) {
                throw DuplicateProductException::duplicateProductsOnCollection();
            }
            $productIds[] = $product->productId;
        }
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
