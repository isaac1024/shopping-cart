<?php

namespace ShoppingCart\Query\Product\Domain;

final readonly class Product
{
    public function __construct(
        private string $id,
        private string $title,
        private string $description,
        private string $photo,
        private int $price,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function photo(): string
    {
        return $this->photo;
    }

    public function price(): int
    {
        return $this->price;
    }
}
