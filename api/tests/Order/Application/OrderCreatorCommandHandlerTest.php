<?php

namespace ShoppingCart\Tests\Order\Application;

use Faker\Factory;
use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Order\Application\OrderCreatorCommandHandler;
use ShoppingCart\Order\Domain\AddressException;
use ShoppingCart\Order\Domain\CartIdException;
use ShoppingCart\Order\Domain\NameException;
use ShoppingCart\Order\Domain\NumberItemsException;
use ShoppingCart\Order\Domain\OrderIdException;
use ShoppingCart\Order\Domain\OrderRepository;
use ShoppingCart\Order\Domain\ProductException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Order\Domain\OrderObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class OrderCreatorCommandHandlerTest extends UnitTestCase
{
    private OrderCreatorCommandHandler $orderCreatorCommandHandler;
    private OrderRepository&MockObject $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->getMockBuilder(OrderRepository::class)->getMock();
        $this->orderCreatorCommandHandler = new OrderCreatorCommandHandler($this->orderRepository);
    }

    public function testCreateOrder(): void
    {
        $command = OrderCreatorCommandObjectMother::make();
        $expectedCart = OrderObjectMother::fromOrderCreatorCommand($command);

        $this->orderRepository->expects($this->once())
            ->method('save')
            ->with($expectedCart);

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithoutItemsShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(productItems: []);
        $this->expectException(NumberItemsException::class);
        $this->expectExceptionMessage("Total order items must be greater than 0");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithoutItemsPriceShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(productItems: [
            [
                'productId' => UuidUtils::random(),
                'title' => 'Custom title',
                'unitPrice' => 0,
                'quantity' => 3,
                'totalPrice' => 0,
            ]
        ]);
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage("Product order price must be greater than 0");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithoutItemsQuantityShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(productItems: [
            [
                'productId' => UuidUtils::random(),
                'title' => 'Custom title',
                'unitPrice' => 5,
                'quantity' => 0,
                'totalPrice' => 0,
            ]
        ]);
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage("Product order quantity must be greater than 0");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithoutNameShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(name: '');
        $this->expectException(NameException::class);
        $this->expectExceptionMessage("Name is empty.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderNameWithWhitespacesShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(name: ' Isaac ');
        $this->expectException(NameException::class);
        $this->expectExceptionMessage("Name ' Isaac ' contain whitespaces at first or end.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithInvalidOrderIdShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make('invalid_order_id');
        $this->expectException(OrderIdException::class);
        $this->expectExceptionMessage("Order id 'invalid_order_id' is not a valid uuid.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithInvalidCartIdShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(cartId: 'invalid_cart_id');
        $this->expectException(CartIdException::class);
        $this->expectExceptionMessage("Cart id 'invalid_cart_id' is not a valid uuid.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithoutAddressShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(address: '');
        $this->expectException(AddressException::class);
        $this->expectExceptionMessage("Address is empty.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderAddressWithWhitespacesShouldFaild(): void
    {
        $command = OrderCreatorCommandObjectMother::make(address: ' c/ Falsa 123 ');
        $this->expectException(AddressException::class);
        $this->expectExceptionMessage("Address ' c/ Falsa 123 ' contain whitespaces at first or end.");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }
}