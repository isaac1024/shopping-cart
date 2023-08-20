<?php

namespace ShoppingCart\Command\Order\Domain;

final readonly class ValidNumberItems
{
    public function __construct(private int $numberItems)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->numberItems <= 0) {
            throw NumberItemsException::orderWithoutItems();
        }
    }

    public function create(): NumberItems
    {
        return new NumberItems($this->numberItems);
    }
}
