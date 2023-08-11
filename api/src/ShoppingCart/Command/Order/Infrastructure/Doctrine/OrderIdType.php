<?php

namespace ShoppingCart\Command\Order\Infrastructure\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use ShoppingCart\Command\Order\Domain\OrderId;

final class OrderIdType extends Type
{
    private const NAME = 'order_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function convertToPHPValue($value, AbstractPlatform $platform): OrderId
    {
        return new OrderId($value);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof OrderId) {
            return $value->value;
        }

        return $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
