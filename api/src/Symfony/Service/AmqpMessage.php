<?php

namespace App\Service;

final readonly class AmqpMessage
{
    public function __construct(private string $body)
    {
    }

    public function __toString(): string
    {
        return $this->body;
    }
}
