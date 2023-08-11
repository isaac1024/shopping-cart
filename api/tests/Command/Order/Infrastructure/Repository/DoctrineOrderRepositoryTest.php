<?php

namespace ShoppingCart\Tests\Command\Order\Infrastructure\Repository;

use ShoppingCart\Command\Order\Domain\OrderRepository;
use ShoppingCart\Command\Order\Infrastructure\Repository\DoctrineOrderRepository;
use ShoppingCart\Tests\Command\Order\Domain\OrderObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class DoctrineOrderRepositoryTest extends IntegrationTestCase
{
    private OrderRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository ??= $this->get(DoctrineOrderRepository::class);
    }

    public function testSave(): void
    {
        $order = OrderObjectMother::make();

        $this->repository->save($order);

        self::addToAssertionCount(1);
    }
}
