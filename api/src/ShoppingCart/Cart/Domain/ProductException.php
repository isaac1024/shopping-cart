<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class ProductException extends ShoppingCartException
{
    private const NEGATIVE_QUANTITY_MESSAGE = "Product cart quantity can't be negative";
    private const NEGATIVE_QUANTITY_ERROR = 'negative_product_cart_quantity';

    public static function negativeQuantity(): ProductException
    {
        return new ProductException(self::NEGATIVE_QUANTITY_ERROR, self::NEGATIVE_QUANTITY_MESSAGE);
    }
}
