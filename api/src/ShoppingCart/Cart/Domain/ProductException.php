<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class ProductException extends ShoppingCartException
{
    private const NEGATIVE_QUANTITY_MESSAGE = "Product cart quantity can't be negative";
    private const NEGATIVE_QUANTITY_ERROR = 'negative_product_cart_quantity';
    private const TOTAL_PRICE_NOT_VALID_MESSAGE = "Product cart total price is not valid";
    private const TOTAL_PRICE_NOT_VALID_ERROR = 'invalid_product_cart_total_price';

    public static function negativeQuantity(): ProductException
    {
        return new ProductException(self::NEGATIVE_QUANTITY_ERROR, self::NEGATIVE_QUANTITY_MESSAGE);
    }

    public static function totalPriceNotValid(): ProductException
    {
        return new ProductException(self::TOTAL_PRICE_NOT_VALID_ERROR, self::TOTAL_PRICE_NOT_VALID_MESSAGE);
    }
}
