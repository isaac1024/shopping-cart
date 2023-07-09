<?php

namespace ShoppingCart\Tests\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Cart\Application\CartCreatorCommandHandler;
use ShoppingCart\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Tests\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartCreatorCommandHandlerTest extends UnitTestCase
{
    private CartRepository&MockObject $cartRepository;
    private CartCreatorCommandHandler $cartCreatorCommandHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->cartCreatorCommandHandler = new CartCreatorCommandHandler($this->cartRepository);
    }

    public function testCreateANewCart(): void
    {
        $command = CartCreatorCommandObjectMother::make();
        $expectedCart = CartObjectMother::fromCartCreatorCommand($command);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($expectedCart);

        $this->cartCreatorCommandHandler->dispatch($command);
    }

    public function testNotCreateANewCartWhenIdIsInvalid(): void
    {
        $command = CartCreatorCommandObjectMother::make('invalidUuid');

        $this->expectException(CartIdException::class);
        $this->expectExceptionMessage(sprintf("Cart id '%s' is not a valid uuid.", $command->cartId));

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->cartCreatorCommandHandler->dispatch($command);
    }
}
