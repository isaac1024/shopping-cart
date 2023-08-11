<?php

namespace ShoppingCart\Command\Cart\Domain;

use ShoppingCart\Shared\Domain\ShoppingCartException;

final class NotFoundCartException extends ShoppingCartException
{
    private const NOT_FOUND_ERROR = 'cart_not_found';
    private const NOT_FOUND_MESSAGE = "Not found cart with id '%s'";

    public static function notFound(string $id): NotFoundCartException
    {
        return new NotFoundCartException(self::NOT_FOUND_ERROR, sprintf(self::NOT_FOUND_MESSAGE, $id));
    }
}
