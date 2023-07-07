<?php

namespace ShoppingCart\Shared\Infrastructure\Bus;

use ShoppingCart\Shared\Domain\Bus\Query;
use ShoppingCart\Shared\Domain\Bus\QueryBus;
use ShoppingCart\Shared\Domain\Bus\QueryResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class SymfonyQueryBus implements QueryBus
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function ask(Query $query): QueryResponse
    {
        $envelope = $this->commandBus->dispatch($query);

        $handledStamp = $envelope->last(HandledStamp::class);
        return $handledStamp->getResult();
    }
}
