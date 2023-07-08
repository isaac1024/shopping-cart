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
}
