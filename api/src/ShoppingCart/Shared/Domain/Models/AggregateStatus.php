<?php

namespace ShoppingCart\Shared\Domain\Models;

enum AggregateStatus
{
    case LOADED;
    case CREATED;
    case UPDATED;
}
