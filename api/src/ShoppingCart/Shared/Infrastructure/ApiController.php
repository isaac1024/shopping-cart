<?php

namespace ShoppingCart\Shared\Infrastructure;

use ShoppingCart\Shared\Domain\Bus\CommandBus;

abstract readonly class ApiController
{
    public function __construct(
        protected CommandBus $commandBus,
        ExceptionToHttpStatusCode $exceptionToHttpStatusCode
    ) {
        foreach ($this->mapExceptions() as $exceptionClass => $statusCode) {
            $exceptionToHttpStatusCode->map($exceptionClass, $statusCode);
        }
    }

    abstract protected function mapExceptions(): array;
}
