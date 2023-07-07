<?php

namespace ShoppingCart\Product\Domain;

interface ProductRepository
{
    public function all(): ProductCollection;
}
