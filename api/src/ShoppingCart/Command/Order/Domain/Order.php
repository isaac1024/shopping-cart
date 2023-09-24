<?php

namespace ShoppingCart\Command\Order\Domain;

use ShoppingCart\Shared\Domain\Models\AggregateRoot;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final class Order extends AggregateRoot
{
    public function __construct(
        private readonly OrderId $orderId,
        private Status $status,
        private Name $name,
        private Address $address,
        private readonly CartId $cartId,
        private readonly NumberItems $numberItems,
        private readonly TotalAmount $totalAmount,
        private readonly ProductCollection $productItems,
        private Timestamps $timestamps,
    ) {
    }

    public static function new(
        string $orderId,
        string $name,
        string $address,
        string $cartId,
        array $productItems,
    ): Order {
        $products = (new ValidProductCollection(...array_map(
            fn (array $product) => (new ValidProduct(
                $product['productId'],
                $product['title'],
                $product['unitPrice'],
                $product['quantity'],
                $product['totalPrice'],
            ))->create(),
            $productItems
        )))->create();
        $totalAmount = $products->totalAmount();
        $order = new Order(
            OrderId::create($orderId),
            Status::PENDING_PAYMENT,
            (new ValidName($name))->create(),
            (new ValidAddress($address))->create(),
            CartId::create($cartId),
            (new ValidNumberItems($products->totalQuantity()))->create(),
            new TotalAmount($totalAmount),
            $products,
            Timestamps::init(),
        );

        return $order;
    }

    public function save(OrderRepository $orderRepository): void
    {
        $order = new OrderModel(
            $this->orderId->value,
            $this->status->value,
            $this->name->value,
            $this->address->value,
            $this->cartId->value,
            $this->numberItems->value,
            $this->totalAmount->value,
            $this->productItems->toArray(),
            $this->timestamps->createdAt,
            $this->timestamps->updatedAt,
            $this->timestamps->aggregateStatus,
        );
        $orderRepository->save($order);
    }
}
