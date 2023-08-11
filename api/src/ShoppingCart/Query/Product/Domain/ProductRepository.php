<?php

namespace ShoppingCart\Query\Product\Domain;

interface ProductRepository
{
    public function all(): ProductCollection;
}
