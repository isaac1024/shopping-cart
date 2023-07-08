<?php

namespace ShoppingCart\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

class NegativeProductPriceException extends ShoppingCartException
{
    private const NEGATIVE_PRICE_MESSAGE = "Product cart price can't be negative";
    private const NEGATIVE_PRICE_ERROR = 'negative_product_cart_price';

    public static function negativePrice(): ProductException
    {
        return new ProductException(self::NEGATIVE_PRICE_ERROR, self::NEGATIVE_PRICE_MESSAGE);
    }
}
