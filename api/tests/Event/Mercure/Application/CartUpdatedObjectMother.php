<?php

namespace ShoppingCart\Tests\Event\Mercure\Application;

use DateTimeImmutable;
use Faker\Factory;
use ShoppingCart\Event\MercurePublisher\Application\CartUpdated;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class CartUpdatedObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?int $numberItems = null,
        ?int $totalAmount = null,
        ?array $productItems = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?string $eventId = null,
        ?DateTimeImmutable $occurredOn = null,
    ): CartUpdated {
        $faker = Factory::create();
        $now = DateTimeUtils::now();

        return CartUpdated::fromConsumer([
            'id' => $eventId ?? UuidUtils::random(),
            'occurredOn' => $occurredOn ?? DateTimeUtils::format($now),
            'data' => [
                'id' => $cartId ?? UuidUtils::random(),
                'attributes' => [
                    'numberItems' => $numberItems ?? 2,
                    'totalAmount' => $totalAmount ?? 10,
                    'productItems' => $productItems ?? [
                            'productId' => UuidUtils::random(),
                            'title' => $faker->title,
                            'photo' => $faker->url,
                            'unitPrice' => 5,
                            'quantity' => 2,
                            'totalPrice' => 10,
                        ],
                    'createdAt' => $createdAt ?? DateTimeUtils::format($now),
                    'updatedAt' => $updatedAt ?? DateTimeUtils::format($now),
                ],
            ],
        ]);
    }
}
