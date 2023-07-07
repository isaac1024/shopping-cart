<?php

namespace ShoppingCart\Shared\Infrastructure;

use ShoppingCart\Shared\Domain\Bus\CommandBus;
use ShoppingCart\Shared\Domain\Bus\QueryBus;

abstract readonly class ApiController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
        ExceptionToHttpStatusCode $exceptionToHttpStatusCode
    ) {
        foreach ($this->mapExceptions() as $exceptionClass => $statusCode) {
            $exceptionToHttpStatusCode->map($exceptionClass, $statusCode);
        }
    }

    abstract protected function mapExceptions(): array;
}
