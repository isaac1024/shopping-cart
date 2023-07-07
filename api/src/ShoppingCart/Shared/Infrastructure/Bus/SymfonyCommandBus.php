<?php

namespace ShoppingCart\Shared\Infrastructure\Bus;

use ShoppingCart\Shared\Domain\Bus\Command;
use ShoppingCart\Shared\Domain\Bus\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SymfonyCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
