<?php

namespace ShoppingCart\Query\Cart\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Query\Cart\Domain\Cart;
use ShoppingCart\Query\Cart\Domain\CartRepository;
use ShoppingCart\Query\Cart\Domain\Product;
use ShoppingCart\Query\Cart\Domain\ProductCollection;

final readonly class DoctrineCartRepository implements CartRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function search(string $cartId): ?Cart
    {
        $sql = "SELECT number_items, total_amount, product_items FROM carts WHERE id = :id";
        $cart = $this->connection->fetchAssociative($sql, ['id' => $cartId]);
        if (!$cart) {
            return null;
        }

        $products = array_map(
            function (array $product) {
                return new Product(
                    $product['productId'],
                    $product['title'],
                    $product['photo'],
                    $product['unitPrice'],
                    $product['quantity'],
                    $product['totalPrice']
                );
            },
            json_decode($cart['product_items'], true)
        );

        return new Cart(
            $cartId,
            $cart['number_items'],
            $cart['total_amount'],
            new ProductCollection(...$products),
        );
    }
}
