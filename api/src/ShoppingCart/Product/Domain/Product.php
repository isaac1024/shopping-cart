<?php

namespace ShoppingCart\Product\Domain;

final readonly class Product
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $photo,
        public int $price,
    ) {
    }
}
