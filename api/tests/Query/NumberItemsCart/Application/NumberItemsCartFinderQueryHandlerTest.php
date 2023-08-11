<?php

namespace ShoppingCart\Tests\Query\NumberItemsCart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Query\NumberItemsCart\Application\NumberItemsCartFinderQueryHandler;
use ShoppingCart\Query\NumberItemsCart\Domain\CartRepository;
use ShoppingCart\Query\NumberItemsCart\Domain\NotFoundCartException;
use ShoppingCart\Tests\Query\NumberItemsCart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class NumberItemsCartFinderQueryHandlerTest extends UnitTestCase
{
    private NumberItemsCartFinderQueryHandler $cartFinderQueryHandler;
    private CartRepository&MockObject $cartRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->cartFinderQueryHandler = new NumberItemsCartFinderQueryHandler($this->cartRepository);
    }

    public function testGetACart(): void
    {
        $query = NumberItemsCartFinderQueryObjectMother::make();
        $cart = CartObjectMother::fromCartFinderQuery($query);
        $expectedResponse = NumberItemsCartFinderResponseObjectMother::fromCart($cart);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(CartIdObjectMother::make($query->id))
            ->willReturn($cart);

        $response = $this->cartFinderQueryHandler->ask($query);

        self::assertEquals($expectedResponse, $response);
    }

    public function testCartNotFound(): void
    {
        $query = NumberItemsCartFinderQueryObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $query->id));

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(CartIdObjectMother::make($query->id))
            ->willReturn(null);

        $this->cartFinderQueryHandler->ask($query);
    }
}
