<?php

namespace ShoppingCart\Tests\Command\Cart\Domain;

use DateTimeImmutable;
use ShoppingCart\Command\Cart\Domain\CartModel;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;

final class CartModelObjectMother
{
    public static function make(
        ?string            $cartId = null,
        ?ProductCollection $productCollection = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DatabaseStatus $databaseStatus = null,
    ): CartModel {
        $productCollection = $productCollection ?? ProductCollection::init();
        $now = DateTimeUtils::now();
        return new CartModel(
            $cartId ?? CartIdObjectMother::make()->value,
            $productCollection->totalQuantity(),
            $productCollection->totalAmount(),
            $productCollection->toArray(),
            $createdAt ?? $now,
            $updatedAt ?? $now,
            $databaseStatus ?? DatabaseStatus::DATABASE_LOADED,
        );
    }
}
