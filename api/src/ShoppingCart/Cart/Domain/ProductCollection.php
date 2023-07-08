<?php

namespace ShoppingCart\Cart\Domain;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, Product>
 */
final readonly class ProductCollection implements Countable, IteratorAggregate
{
    public array $products;

    public function __construct(Product ...$products)
    {
        $this->validate($products);
        $this->products = $products;
    }

    public function count(): int
    {
        return count($this->products);
    }

    public function getIterator(): Traversable
    {
        yield from $this->products;
    }

    public static function init(): ProductCollection
    {
        return new ProductCollection();
    }

    public function toArray(): array
    {
        return $this->products;
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
        $productId = $product->productId;
        $products = array_filter($this->products, fn (Product $product) => $product->productId !== $productId);

        return new ProductCollection($product, ...$products);
    }

    private function validate(array $products): void
    {
        $productIds = [];
        /** @var Product $product */
        foreach ($products as $product) {
            if ($product->quantity === 0) {
                throw ProductCollectionException::zeroQuantity();
            }
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
