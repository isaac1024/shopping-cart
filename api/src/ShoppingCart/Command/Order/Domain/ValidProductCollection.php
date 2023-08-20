<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class ValidProductCollection
{
    /**
     * @var Product[]
     */
    private array $products;

    public function __construct(Product ...$products)
    {
        $this->validate($products);
        $this->products = $products;
    }

    private function validate(array $products): void
    {
        $productIds = [];
        foreach ($products as $product) {
            if (in_array($product->productId, $productIds, true)) {
                throw DuplicateProductException::duplicateProductsOnCollection();
            }
            $productIds[] = $product->productId;
        }
    }

    public function create(): ProductCollection
    {
        return new ProductCollection(...$this->products);
    }
}
