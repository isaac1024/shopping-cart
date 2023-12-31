<?php

namespace ShoppingCart\Tests\Query\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Query\Cart\Application\CartFinderQueryHandler;
use ShoppingCart\Query\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
use ShoppingCart\Tests\Query\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Domain\Models\CartIdObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartFinderQueryHandlerTest extends UnitTestCase
{
    private CartFinderQueryHandler $cartFinderQueryHandler;
    private CartRepository&MockObject $cartRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->cartFinderQueryHandler = new CartFinderQueryHandler($this->cartRepository);
    }

    public function testGetACart(): void
    {
        $query = CartFinderQueryObjectMother::make();
        $cart = CartObjectMother::fromCartFinderQuery($query);
        $expectedResponse = CartFinderResponseObjectMother::fromCart($cart);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(CartIdObjectMother::make($query->id))
            ->willReturn($cart);

        $response = $this->cartFinderQueryHandler->ask($query);

        self::assertEquals($expectedResponse, $response);
    }

    public function testCartNotFound(): void
    {
        $query = CartFinderQueryObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $query->id));

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(CartIdObjectMother::make($query->id))
            ->willReturn(null);

        $this->cartFinderQueryHandler->ask($query);
    }
}
