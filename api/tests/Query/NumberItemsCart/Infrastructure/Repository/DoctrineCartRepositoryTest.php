<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Infrastructure\Repository;

use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;
use ShoppingCart\Query\NumberItemsCart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\NumberItemsCart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrineCartRepositoryTest extends IntegrationTestCase
{
    private CartRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrineCartRepository::class);
    }

    public function testFindACart(): void
    {
        $cartId = CartIdObjectMother::make();
        $expectedCart = CartObjectMother::make($cartId->value, 0);
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => 0,
            'total_amount' => 0,
            'product_items' => json_encode([]),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $cart = $this->repository->search($expectedCart->id());

        self::assertEquals($expectedCart, $cart);
    }

    public function testNotFindACart(): void
    {
        $cart = $this->repository->search(UuidUtils::random());

        self::assertNull($cart);
    }
}
