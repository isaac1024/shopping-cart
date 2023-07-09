<?php

namespace ShoppingCart\Shared\Domain\Bus;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}