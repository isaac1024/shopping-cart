<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrineCartRepositoryTest extends IntegrationTestCase
{
    private CartRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrineCartRepository::class);
    }

    public function testSave(): void
    {
        $cart = CartObjectMother::make();

        $this->repository->save($cart);

        self::addToAssertionCount(1);
    }

    public function testFindACart(): void
    {
        $expectedCart = CartObjectMother::make();

        $this->repository->save($expectedCart);

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->clear();

        $cart = $this->repository->find(new CartId($expectedCart->getCartId()));

        self::assertEquals($expectedCart, $cart);
    }

    public function testNotFindACart(): void
    {
        $cart = $this->repository->find(new CartId(UuidUtils::random()));

        self::assertNull($cart);
    }

    public function testFoundAProduct(): void
    {
        $productId = 'd2d7d6d8-b056-492f-b703-99884085c862';
        $title = 'Clean Architecture';

        $product = $this->repository->findProduct($productId);

        self::assertEquals($productId, $product->productId);
        self::assertEquals($title, $product->title);
    }

    public function testNotFoundProduct(): void
    {
        $productId = '79eef388-802c-4ac4-a586-93b66ebb3a5d';

        $product = $this->repository->findProduct($productId);

        self::assertNull($product);
    }
}
