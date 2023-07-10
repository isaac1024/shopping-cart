<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\AggregateRoot;
use ShoppingCart\Shared\Domain\Models\CartId;

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
    ) {
    }

    public static function new(
        string $orderId,
        string $name,
        string $address,
        string $cartId,
        array $productItems,
        string $cardNumber,
        string $cardValidDate,
        string $cardCvv,
    ): Order {
        $products = new ProductCollection(...array_map(
            fn (array $product) => new Product(
                $product['productId'],
                $product['title'],
                $product['unitPrice'],
                $product['quantity'],
                $product['totalPrice'],
            ),
            $productItems
        ));
        $totalAmount = $products->totalAmount();
        $order = new Order(
            new OrderId($orderId),
            Status::PENDING_PAYMENT,
            new Name($name),
            new Address($address),
            new CartId($cartId),
            new NumberItems($products->totalQuantity()),
            new TotalAmount($totalAmount),
            $products,
        );

        $order->registerNewEvent(new OrderPendingToPay(
            $orderId,
            $name,
            $totalAmount,
            $cardNumber,
            $cardValidDate,
            $cardCvv
        ));

        return $order;
    }

    public function save(OrderRepository $orderRepository, EventBus $eventBus): void
    {
        $orderRepository->save($this);
        $this->publishEvents($eventBus);
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount->value;
    }
}
