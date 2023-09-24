<?php

namespace ShoppingCart\Tests\Command\Cart\Infrastructure\Repository;

use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Command\Cart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductCollectionOrderMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\TimestampsObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrineCartRepositoryTest extends IntegrationTestCase
{
    private CartRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrineCartRepository::class);
    }

    public function testCreateCart(): void
    {
        $now = DateTimeUtils::now();
        $productCollection = ProductCollectionOrderMother::make(2);
        $cartId = UuidUtils::random();
        $cart = CartModelObjectMother::make($cartId, $productCollection, $now, $now, DatabaseStatus::CREATED);

        $this->repository->save($cart);

        $this->assertHasDatabase('carts', ['id' => $cartId]);
    }

    public function testUpdateCart(): void
    {
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollection::init();
        $now = DateTimeUtils::now();

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $updatedProductCollection = ProductCollectionOrderMother::make(2);
        $cart = CartModelObjectMother::make($cartId->value, $updatedProductCollection, $now, $now, DatabaseStatus::UPDATED);

        $this->repository->save($cart);

        $this->assertHasDatabase('carts', ['id' => $cartId, 'number_items' => $updatedProductCollection->totalQuantity()]);
    }

    public function testFindACart(): void
    {
        $now = DateTimeUtils::now();
        $cartId = CartIdObjectMother::make();
        $productCollection = ProductCollectionOrderMother::make(2);
        $expectedCart = CartObjectMother::make($cartId, $productCollection, timestamps: TimestampsObjectMother::make($now, $now, DatabaseStatus::DATABASE_LOADED));

        $this->prepareRecord('carts', [
            'id' => $cartId->value,
            'number_items' => $productCollection->totalQuantity(),
            'total_amount' => $productCollection->totalAmount(),
            'product_items' => json_encode($productCollection->toArray()),
            'created_at' => DateTimeUtils::toDatabase($now),
            'updated_at' => DateTimeUtils::toDatabase($now),
        ]);

        $cart = $this->repository->search($cartId->value);

        self::assertEquals($expectedCart, $cart);
    }

    public function testNotFindACart(): void
    {
        $cart = $this->repository->search(UuidUtils::random());

        self::assertNull($cart);
    }

    public function testFoundAProduct(): void
    {
        $productId = 'd2d7d6d8-b056-492f-b703-99884085c862';
        $title = 'Clean Architecture';

        $product = $this->repository->searchProduct($productId);

        self::assertEquals($productId, $product->productId);
        self::assertEquals($title, $product->title);
    }

    public function testNotFoundProduct(): void
    {
        $productId = '79eef388-802c-4ac4-a586-93b66ebb3a5d';

        $product = $this->repository->searchProduct($productId);

        self::assertNull($product);
    }
}
