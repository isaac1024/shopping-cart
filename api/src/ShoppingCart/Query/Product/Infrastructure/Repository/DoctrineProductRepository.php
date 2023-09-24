<?php

namespace ShoppingCart\Query\Product\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use ShoppingCart\Query\Product\Domain\Product;
use ShoppingCart\Query\Product\Domain\ProductCollection;
use ShoppingCart\Query\Product\Domain\ProductRepository;

final readonly class DoctrineProductRepository implements ProductRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function all(): ProductCollection
    {
        $sql = "SELECT * FROM products";
        $dataProducts = $this->connection->fetchAllAssociative($sql);

        $prodcuts = array_map(
            function (array $product) {
                return new Product(
                    $product['id'],
                    $product['title'],
                    $product['description'],
                    $product['photo'],
                    $product['price'],
                );
            },
            $dataProducts
        );
        return new ProductCollection(...$prodcuts);
    }
}
