<?php

namespace ShoppingCart\Command\Order\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Command\Order\Domain\OrderModel;
use ShoppingCart\Command\Order\Domain\OrderRepository;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;

final readonly class DoctrineOrderRepository implements OrderRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(OrderModel $order): void
    {
        $sql = match ($order->aggregateStatus) {
            AggregateStatus::CREATED => <<<SQL
                INSERT INTO orders (
                    id,
                    cart_id,
                    status,
                    address,
                    name,
                    number_items,
                    total_amount,
                    product_items,
                    created_at,
                    updated_at
                )
                VALUES (
                    :id,
                    :cart_id,
                    :status,
                    :address,
                    :name,
                    :number_items,
                    :total_amount,
                    :product_items,
                    :created_at,
                    :updated_at
                )
            SQL,
            AggregateStatus::UPDATED => <<<SQL
                UPDATE orders
                SET status = :status
                WHERE id = :id
            SQL,
            AggregateStatus::LOADED => null,
        };
        if (!$sql) {
            return;
        }

        $this->connection->executeQuery($sql, [
            'id' => $order->orderId,
            'cart_id' => $order->cartId,
            'status' => $order->status,
            'address' => $order->address,
            'name' => $order->name,
            'number_items' => $order->numberItems,
            'total_amount' => $order->totalAmount,
            'product_items' => json_encode($order->productItems),
            'created_at' => DateTimeUtils::toDatabase($order->createdAt),
            'updated_at' => DateTimeUtils::toDatabase($order->updatedAt),
        ]);
    }
}
