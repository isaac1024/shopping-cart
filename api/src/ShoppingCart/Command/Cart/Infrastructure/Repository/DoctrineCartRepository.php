<?php

namespace ShoppingCart\Command\Cart\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Command\Cart\Domain\Cart;
use ShoppingCart\Command\Cart\Domain\CartModel;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\NumberItems;
use ShoppingCart\Command\Cart\Domain\Product;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Command\Cart\Domain\TotalAmount;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\Timestamps;

final readonly class DoctrineCartRepository implements CartRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(CartModel $cart): void
    {
        $sql = match ($cart->databaseStatus) {
            DatabaseStatus::CREATED => <<<SQL
                INSERT INTO carts (id, number_items, total_amount, product_items, created_at, updated_at)
                VALUES (:id, :number_items, :total_amount, :product_items, :created_at, :updated_at)
            SQL,
            DatabaseStatus::UPDATED => <<<SQL
                UPDATE carts
                SET number_items = :number_items,
                    total_amount = :total_amount,
                    product_items = :product_items,
                    updated_at = :updated_at
                WHERE id = :id
            SQL,
            DatabaseStatus::DATABASE_LOADED => null,
        };
        if (!$sql) {
            return;
        }

        $this->connection->executeQuery($sql, [
            'id' => $cart->cartId,
            'number_items' => $cart->numberItems,
            'total_amount' => $cart->totalAmount,
            'product_items' => json_encode($cart->productItems),
            'created_at' => DateTimeUtils::toDatabase($cart->createdAt),
            'updated_at' => DateTimeUtils::toDatabase($cart->updatedAt),
        ]);
    }

    public function search(string $cartId): ?Cart
    {
        $sql = "SELECT number_items, total_amount, product_items, created_at, updated_at FROM carts WHERE id = :id";
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
            new CartId($cartId),
            new NumberItems($cart['number_items']),
            new TotalAmount($cart['total_amount']),
            new ProductCollection(...$products),
            Timestamps::fromDatabase($cart['created_at'], $cart['updated_at']),
        );
    }

    public function searchProduct(string $productId): ?Product
    {
        $sql = "SELECT id, photo, title, price FROM products WHERE id = :id";
        $productData = $this->connection->fetchAssociative($sql, ['id' => $productId]);
        if ($productData === false) {
            return null;
        }

        return Product::init($productData['id'], $productData['title'], $productData['photo'], $productData['price']);
    }
}
