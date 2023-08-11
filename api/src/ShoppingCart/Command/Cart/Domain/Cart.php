<?php

namespace ShoppingCart\Command\Cart\Domain;

use ShoppingCart\Shared\Domain\Models\AggregateRoot;
use ShoppingCart\Shared\Domain\Models\CartId;

final class Cart extends AggregateRoot
{
    public function __construct(
        private readonly CartId $cartId,
        private NumberItems $numberItems,
        private TotalAmount $totalAmount,
        private ProductCollection $productItems,
    ) {
    }

    public static function new(string $cartId): Cart
    {
        return new Cart(
            CartId::create($cartId),
            NumberItems::init(),
            TotalAmount::init(),
            ProductCollection::init(),
        );
    }

    public function save(CartRepository $cartRepository): void
    {
        $cartRepository->save($this);
    }

    public function updateProduct(string $productId, int $quantity, CartRepository $cartRepository): Cart
    {
        $product = $this->productItems->get($productId) ?? $cartRepository->findProduct($productId);
        if (!$product) {
            throw CartException::productNotExist($productId);
        }

        $product = $product->updateQuantity($quantity);
        $this->productItems = $this->productItems->add($product);
        $this->updateNumberItems();
        $this->updateTotalAmount();

        return $this;
    }

    private function updateNumberItems(): void
    {
        $this->numberItems = new NumberItems($this->productItems->totalQuantity());
    }

    private function updateTotalAmount(): void
    {
        $this->totalAmount = new TotalAmount($this->productItems->totalAmount());
    }

    public function removeProduct(string $productId): Cart
    {
        $this->productItems = $this->productItems->remove($productId);
        $this->updateNumberItems();
        $this->updateTotalAmount();

        return $this;
    }

    public function cartId(): string
    {
        return $this->cartId->value;
    }

    public function numberItems(): int
    {
        return $this->numberItems->value;
    }

    public function totalAmount(): int
    {
        return $this->totalAmount->value;
    }

    public function productItems(): array
    {
        return $this->productItems->toArray();
    }
}
