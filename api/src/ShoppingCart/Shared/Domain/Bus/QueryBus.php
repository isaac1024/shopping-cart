<?php

namespace ShoppingCart\Shared\Domain\Bus;

interface QueryBus
{
    public function ask(Query $query): QueryResponse;
}
