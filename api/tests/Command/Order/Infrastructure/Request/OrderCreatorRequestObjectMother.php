<?php

namespace ShoppingCart\Tests\Command\Order\Infrastructure\Request;

use Faker\Factory;
use ShoppingCart\Shared\Domain\Models\UuidUtils;

final class OrderCreatorRequestObjectMother
{
    public static function make(
        ?string $cartId = null,
        ?string $name = null,
        ?string $address = null,
        ?string $number = null,
        ?string $validDate = null,
        ?string $cvv = null,
    ): array {
        $faker = Factory::create();
        return [
            'cartId' => $cartId ?? UuidUtils::random(),
            'name' => $name ?? $faker->name(),
            'address' => $address ?? $faker->address(),
            'card' => [
                'number' => $number ?? $faker->creditCardNumber(),
                'validDate' => $validDate ?? $faker->creditCardExpirationDateString(expirationDateFormat: 'm/y'),
                'cvv' => $cvv ?? $faker->numerify(),
            ],
        ];
    }
}
