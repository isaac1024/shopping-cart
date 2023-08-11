<?php

namespace ShoppingCart\Command\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class DuplicateProductException extends ShoppingCartException
{
    private const DUPLICATE_PRODUCTS_ON_COLLECTION_ERROR = 'duplicate_products_on_collection';
    private const DUPLICATE_PRODUCTS_ON_COLLECTION_MESSAGE = "Product collection can't contain same product many times";

    public static function duplicateProductsOnCollection(): DuplicateProductException
    {
        return new DuplicateProductException(
            self::DUPLICATE_PRODUCTS_ON_COLLECTION_ERROR,
            self::DUPLICATE_PRODUCTS_ON_COLLECTION_MESSAGE
        );
    }
}
