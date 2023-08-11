<?php

namespace ShoppingCart\Command\Cart\Infrastructure\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use ShoppingCart\Command\Cart\Domain\Product;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use stdClass;

final class ProductCollectionType extends Type
{
    private const NAME = 'cart_product_items';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function convertToPHPValue($value, AbstractPlatform $platform): ProductCollection
    {
        return new ProductCollection(...array_map(
            fn (stdClass $product) => new Product(
                $product->productId,
                $product->title,
                $product->unitPrice,
                $product->quantity,
                $product->totalPrice
            ),
            json_decode($value)
        ));
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof ProductCollection) {
            return json_encode($value->toArray());
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
