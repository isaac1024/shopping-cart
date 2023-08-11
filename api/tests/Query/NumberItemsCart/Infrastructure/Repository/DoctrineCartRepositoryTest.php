<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;
use ShoppingCart\Query\NumberItemsCart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\NumberItemsCart\Domain\CartObjectMother;
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
        $expectedCart = CartObjectMother::make();

        $sql = "INSERT INTO carts (id, number_items, total_amount, product_items) VALUES (?, ?, ?, ?)";
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->getConnection()->executeQuery($sql, [$expectedCart->id(), $expectedCart->numberItems(), 0, "{}"]);
        $em->clear();

        $cart = $this->repository->search($expectedCart->id());

        self::assertEquals($expectedCart, $cart);
    }

    public function testNotFindACart(): void
    {
        $cart = $this->repository->search(UuidUtils::random());

        self::assertNull($cart);
    }
}
