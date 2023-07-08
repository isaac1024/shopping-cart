<?php

namespace ShoppingCart\Tests\Cart\Infrastructure\Repository;

use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Cart\Infrastructure\Repository\DoctrineCartRepository;
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
}
