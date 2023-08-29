<?php

namespace ShoppingCart\Tests\Command\Order\Application;

use Faker\Factory;
use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Command\Order\Application\OrderCreatorCommandHandler;
use ShoppingCart\Command\Order\Domain\AddressException;
use ShoppingCart\Command\Order\Domain\DuplicateProductException;
use ShoppingCart\Command\Order\Domain\NameException;
use ShoppingCart\Command\Order\Domain\NumberItemsException;
use ShoppingCart\Command\Order\Domain\OrderIdException;
use ShoppingCart\Command\Order\Domain\OrderRepository;
use ShoppingCart\Command\Order\Domain\ProductException;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\CartIdException;
use ShoppingCart\Shared\Domain\Models\UuidUtils;
use ShoppingCart\Tests\Command\Order\Domain\OrderObjectMother;
use ShoppingCart\Tests\Command\Order\Domain\OrderPendingToPayObjectMother;
use ShoppingCart\Tests\Command\Order\Domain\ProductObjectMother;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class OrderCreatorCommandHandlerTest extends UnitTestCase
{
    private OrderCreatorCommandHandler $orderCreatorCommandHandler;
    private OrderRepository&MockObject $orderRepository;
    private EventBus&MockObject $eventBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->getMockBuilder(OrderRepository::class)->getMock();
        $this->orderCreatorCommandHandler = new OrderCreatorCommandHandler($this->orderRepository);
    }

    public function testCreateOrder(): void
    {
        $command = OrderCreatorCommandObjectMother::make();
        $expectedOrder = OrderObjectMother::fromOrderCreatorCommand($command);

        $this->orderRepository->expects($this->once())
            ->method('save')
            ->with($expectedOrder);

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

    public function testCreateOrderNameTooLongShouldFaild(): void
    {
        $faker = Factory::create();
        $name = $faker->realTextBetween(181);
        $command = OrderCreatorCommandObjectMother::make(name: $name);
        $this->expectException(NameException::class);
        $this->expectExceptionMessage(sprintf("Name %s is too long. Max length 180", $name));

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

    public function testCreateOrderAddressTooLongShouldFaild(): void
    {
        $faker = Factory::create();
        $address = $faker->realTextBetween(256, 300);
        $command = OrderCreatorCommandObjectMother::make(address: $address);
        $this->expectException(AddressException::class);
        $this->expectExceptionMessage(sprintf("Address %s is too long. Max length 255", $address));

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderWithDuplicatedProductShouldFaild(): void
    {
        $product = ProductObjectMother::make();
        $command = OrderCreatorCommandObjectMother::make(productItems: [$product->toArray(), $product->toArray()]);
        $this->expectException(DuplicateProductException::class);
        $this->expectExceptionMessage("Product collection can't contain same product many times");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }

    public function testCreateOrderInconsistentProductPriceShouldFaild(): void
    {
        $faker = Factory::create();
        $command = OrderCreatorCommandObjectMother::make(productItems: [[
            'productId' => UuidUtils::random(),
            'title' => $faker->title(),
            'unitPrice' => $faker->numberBetween(1, 3),
            'quantity' => $faker->numberBetween(1, 10),
            'totalPrice' => $faker->numberBetween(100, 1000),
        ]]);
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage("Product order total price is not valid");

        $this->orderRepository->expects($this->never())
            ->method('save');

        $this->orderCreatorCommandHandler->dispatch($command);
    }
}
