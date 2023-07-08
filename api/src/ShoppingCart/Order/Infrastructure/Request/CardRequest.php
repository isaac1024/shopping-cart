<?php

namespace ShoppingCart\Order\Infrastructure\Request;

final readonly class CardRequest
{
    public function __construct(public string $number, public string $validDate, public string $cvv)
    {
    }
}