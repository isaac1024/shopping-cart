<?php

namespace ShoppingCart\Shared\Domain;

interface Logger
{
    public function info(string $message, array $context = []);
}