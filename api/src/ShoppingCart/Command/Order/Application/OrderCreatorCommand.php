<?php

namespace ShoppingCart\Command\Order\Application;

use ShoppingCart\Shared\Domain\Bus\Command;

final readonly class OrderCreatorCommand implements Command
{
    public function __construct(
        public string $orderId,
        public string $name,
        public string $address,
        public string $cartId,
        public array $productItems,
        public string $cardNumber,
        public string $cardValidDate,
        public string $cardCvv,
    ) {
    }
}
