<?php

namespace ShoppingCart\Order\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class ProductException extends ShoppingCartException
{
    private const NO_QUANTITY_MESSAGE = "Product order quantity must be greater than 0";
    private const NO_QUANTITY_ERROR = 'no_product_order_quantity';
    private const TOTAL_PRICE_NOT_VALID_MESSAGE = "Product order total price must be greater than 0";
    private const TOTAL_PRICE_NOT_VALID_ERROR = 'invalid_product_order_total_price';
    private const NO_PRICE_MESSAGE = "Product order price must be greater than 0";
    private const NO_PRICE_ERROR = 'no_product_order_price';

    public static function noQuantity(): ProductException
    {
        return new ProductException(self::NO_QUANTITY_ERROR, self::NO_QUANTITY_MESSAGE);
    }

    public static function totalPriceNotValid(): ProductException
    {
        return new ProductException(self::TOTAL_PRICE_NOT_VALID_ERROR, self::TOTAL_PRICE_NOT_VALID_MESSAGE);
    }

    public static function noPrice(): ProductException
    {
        return new ProductException(self::NO_PRICE_ERROR, self::NO_PRICE_MESSAGE);
    }
}
