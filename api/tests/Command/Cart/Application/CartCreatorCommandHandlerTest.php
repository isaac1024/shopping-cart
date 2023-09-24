<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartCreatorCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Domain\Models\DatabaseStatus;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
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
        $cartModel = CartModelObjectMother::make($command->cartId, databaseStatus: DatabaseStatus::CREATED);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

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
