<?php

namespace ShoppingCart\Shared\Domain;

use DomainException;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class ShoppingCartException extends DomainException
{
    public function __construct(public readonly string $errorCode, string $message)
    {
        parent::__construct($message);
    }
}
