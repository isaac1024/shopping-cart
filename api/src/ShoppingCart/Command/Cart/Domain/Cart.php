<?php

namespace ShoppingCart\Command\Cart\Domain;

use ShoppingCart\Shared\Domain\Models\AggregateRoot;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final class Cart extends AggregateRoot
{
    public function __construct(
        private readonly CartId $cartId,
        private NumberItems $numberItems,
        private TotalAmount $totalAmount,
        private ProductCollection $productItems,
        private Timestamps $timestamps,
    ) {
    }

    public static function new(string $cartId): Cart
    {
        return new Cart(
            CartId::create($cartId),
            NumberItems::init(),
            TotalAmount::init(),
            ProductCollection::init(),
            Timestamps::init(),
        );
    }

    public function save(CartRepository $cartRepository): void
    {
        $model = new CartModel(
            $this->cartId->value,
            $this->numberItems->value,
            $this->totalAmount->value,
            $this->productItems->toArray(),
            $this->timestamps->createdAt,
            $this->timestamps->updatedAt,
        );
        $cartRepository->save($model);
    }

    public function updateProduct(string $productId, int $quantity, CartRepository $cartRepository): Cart
    {
        $product = $this->productItems->get($productId) ?? $cartRepository->searchProduct($productId);
        if (!$product) {
            throw CartException::productNotExist($productId);
        }

        $product = $product->addQuantity($quantity);
        $this->productItems = $this->productItems->add($product);
        $this->updateNumberItems();
        $this->updateTotalAmount();
        $this->timestamps = $this->timestamps->update();

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
        $this->timestamps = $this->timestamps->update();

        return $this;
    }
}
