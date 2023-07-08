<?php

namespace ShoppingCart\Cart\Domain;

final class Cart
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
            new CartId($cartId),
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

    public function getCartId(): string
    {
        return $this->cartId->value;
    }

    public function getNumberItems(): int
    {
        return $this->numberItems->value;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount->value;
    }

    public function getProductItems(): array
    {
        return $this->productItems->toArray();
    }
}
