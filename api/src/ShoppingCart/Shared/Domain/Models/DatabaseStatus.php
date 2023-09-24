<?php

namespace ShoppingCart\Shared\Domain\Models;

enum DatabaseStatus
{
    case DATABASE_LOADED;
    case CREATED;
    case UPDATED;
}
