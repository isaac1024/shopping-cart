<?php

namespace ShoppingCart\Shared\Infrastructure;

use Psr\Log\LoggerInterface;
use ShoppingCart\Shared\Domain\Logger;

final readonly class SymfonyLogger implements Logger
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }
}
