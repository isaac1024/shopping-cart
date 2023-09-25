<?php

namespace ShoppingCart\Tests\Command\Cart\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Cart\Application\CartProductRemoverCommandHandler;
use ShoppingCart\Command\Cart\Domain\CartRepository;
use ShoppingCart\Command\Cart\Domain\ProductCollection;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\CartId;
use ShoppingCart\Shared\Domain\Models\AggregateStatus;
use ShoppingCart\Shared\Domain\Models\NotFoundCartException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Cart\Domain\CartModelObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\CartUpdatedObjectMother;
use ShoppingCart\Tests\Command\Cart\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class CartProductRemoverCommandHandlerTest extends UnitTestCase
{
    private CartRepository&MockObject $cartRepository;
    private CartProductRemoverCommandHandler $cartProductRemoverCommandHandler;
    private EventBus&MockObject $eventBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)->getMock();
        $this->eventBus = $this->getMockBuilder(EventBus::class)->getMock();
        $this->cartProductRemoverCommandHandler = new CartProductRemoverCommandHandler($this->cartRepository, $this->eventBus);
    }

    public function testRemoveAProduct(): void
    {
        $product = ProductObjectMother::make();
        $productCollection = new ProductCollection($product);
        $command = CartProductRemoverCommandObjectMother::make(productId: $product->productId);
        $cartModel = CartModelObjectMother::make($command->cartId, ProductCollection::init(), aggregateStatus: AggregateStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);
        $cartUpdatedEvent = CartUpdatedObjectMother::fromCartModel($cartModel);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with($command->cartId)
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->eventBus->expects($this->once())
            ->method('publish')
            ->with($cartUpdatedEvent);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testRemoveAProductFromMany(): void
    {
        $firstProduct = ProductObjectMother::make();
        $secondProduct = ProductObjectMother::make();
        $thirdProduct = ProductObjectMother::make();
        $productCollection = new ProductCollection($firstProduct, $secondProduct, $thirdProduct);
        $command = CartProductRemoverCommandObjectMother::make(productId: $firstProduct->productId);
        $cartModel = CartModelObjectMother::make($command->cartId, new ProductCollection($secondProduct, $thirdProduct), aggregateStatus: AggregateStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);
        $cartUpdatedEvent = CartUpdatedObjectMother::fromCartModel($cartModel);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with($command->cartId)
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->eventBus->expects($this->once())
            ->method('publish')
            ->with($cartUpdatedEvent);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testRemoveAProductThatNotExistOnCart(): void
    {
        $product = ProductObjectMother::make();
        $productCollection = new ProductCollection($product);
        $command = CartProductRemoverCommandObjectMother::make(productId: UuidUtils::random());
        $cartModel = CartModelObjectMother::make($command->cartId, $productCollection, aggregateStatus: AggregateStatus::UPDATED);
        $cart = CartObjectMother::fromCartProductRemoverCommand($command, $productCollection);
        $cartUpdatedEvent = CartUpdatedObjectMother::fromCartModel($cartModel);

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn($cart);

        $this->cartRepository->expects($this->once())
            ->method('save')
            ->with($cartModel);

        $this->eventBus->expects($this->once())
            ->method('publish')
            ->with($cartUpdatedEvent);

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }

    public function testNotFoundCart(): void
    {
        $command = CartProductRemoverCommandObjectMother::make();
        $this->expectException(NotFoundCartException::class);
        $this->expectExceptionMessage(sprintf("Not found cart with id '%s'", $command->cartId));

        $this->cartRepository->expects($this->once())
            ->method('search')
            ->with(new CartId($command->cartId))
            ->willReturn(null);

        $this->cartRepository->expects($this->never())
            ->method('save');

        $this->eventBus->expects($this->never())
            ->method('publish');

        $this->cartProductRemoverCommandHandler->dispatch($command);
    }
}
