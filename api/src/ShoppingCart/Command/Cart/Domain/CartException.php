<?php

namespace ShoppingCart\Command\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class CartException extends ShoppingCartException
{
    private const PRODUCT_NOT_EXIST_ERROR = 'product_not_exist';
    private const PRODUCT_NOT_EXIT_MESSAGE = "Not exist a product with id '%s'";

    public static function productNotExist(string $productId): CartException
    {
        return new CartException(self::PRODUCT_NOT_EXIST_ERROR, sprintf(self::PRODUCT_NOT_EXIT_MESSAGE, $productId));
    }
}
