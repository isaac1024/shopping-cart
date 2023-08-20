<?php

namespace ShoppingCart\Command\Order\Domain;

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

    public function totalAmount(): int
    {
        return $this->totalAmount->value;
    }
}
