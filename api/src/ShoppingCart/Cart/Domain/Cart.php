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
