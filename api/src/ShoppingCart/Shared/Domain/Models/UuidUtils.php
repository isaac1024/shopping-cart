<?php

namespace ShoppingCart\Shared\Domain\Models;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

final class UuidUtils
{
    public static function random(): string
    {
        return (string) SymfonyUuid::v4();
    }

    public static function isValid(string $uuid): bool
    {
        return SymfonyUuid::isValid($uuid);
    }
}
