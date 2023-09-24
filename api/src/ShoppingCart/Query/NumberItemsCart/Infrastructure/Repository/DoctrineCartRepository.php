<?php

namespace ShoppingCart\Query\NumberItemsCart\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Query\NumberItemsCart\Domain\Cart;
use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;

final readonly class DoctrineCartRepository implements CartRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function search(string $cartId): ?Cart
    {
        $sql = "SELECT number_items FROM carts WHERE id = :id";
        $cart = $this->connection->fetchAssociative($sql, ['id' => $cartId]);

        return $cart ? new Cart($cartId, $cart['number_items']) : null;
    }
}
