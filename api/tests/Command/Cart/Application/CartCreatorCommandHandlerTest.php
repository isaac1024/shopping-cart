<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartCreatorCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Tests\Command\Cart\Domain\CartCreatedObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartCreatorCommandHandlerTest extends UnitTestCase
{
    private CartRepository&MockObject $cartRepository;
    private CartCreatorCommandHandler $cartCreatorCommandHandler;
    private EventBus&MockObject $eventBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->eventBus = $this->getMockBuilder(EventBus::class)->getMock();
        $this->cartCreatorCommandHandler = new CartCreatorCommandHandler($this->cartRepository, $this->eventBus);
    }

    public function testCreateANewCart(): void
    {
        $command = CartCreatorCommandObjectMother::make();
        $cartModel = CartModelObjectMother::make($command->cartId, aggregateStatus: AggregateStatus::CREATED);
        $cartCreatedEvent = CartCreatedObjectMother::fromCartModel($cartModel);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->eventBus->expects($this->once())
            ->method('publish')
            ->with($cartCreatedEvent);

        $this->cartCreatorCommandHandler->dispatch($command);
    }

    public function testNotCreateANewCartWhenIdIsInvalid(): void
    {
        $command = CartCreatorCommandObjectMother::make('invalidUuid');

        $this->expectException(CartIdException::class);
        $this->expectExceptionMessage(sprintf("Cart id '%s' is not a valid uuid.", $command->cartId));

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->eventBus->expects($this->never())
            ->method('publish');

        $this->cartCreatorCommandHandler->dispatch($command);
    }
}
