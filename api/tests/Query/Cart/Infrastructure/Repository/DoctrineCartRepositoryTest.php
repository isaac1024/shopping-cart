<?php

namespace ShoppingCart\Tests\Query\Cart\Infrastructure\Repository;

use ShoppingCart\Query\Cart\Domain\CartRepository;
use ShoppingCart\Query\Cart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\Cart\Domain\ProductCollectionOrderMother;
use ShoppingCart\Tests\Query\Cart\Domain\CartObjectMother;
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
        $productCollection = ProductCollectionOrderMother::make(2);
        $expectedCart = CartObjectMother::make($cartId->value, $productCollection);
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
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
