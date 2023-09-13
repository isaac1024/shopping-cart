<?php

namespace ShoppingCart\Tests\Query\Cart\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use ShoppingCart\Query\Cart\Domain\CartRepository;
use ShoppingCart\Query\Cart\Infrastructure\Repository\DoctrineCartRepository;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Query\Cart\Domain\CartObjectMother;
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

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($expectedCart);
        $em->flush();
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
