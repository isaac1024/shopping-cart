<?php

namespace ShoppingCart\Command\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class ProductCollectionException extends ShoppingCartException
{
    private const ZERO_QUANTITY_ERROR = 'zero_quantity';
    private const ZERO_QUANTITY_MESSAGE = "Can't add a product with 0 quantity";

    public static function zeroQuantity(): ProductCollectionException
    {
        return new ProductCollectionException(self::ZERO_QUANTITY_ERROR, self::ZERO_QUANTITY_MESSAGE);
    }
}
