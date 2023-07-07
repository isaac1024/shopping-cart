<?php

namespace ShoppingCart\Shared\Domain\Bus;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
