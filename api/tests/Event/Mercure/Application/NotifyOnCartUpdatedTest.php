<?php

namespace ShoppingCart\Tests\Event\Mercure\Application;

use PHPUnit\Framework\MockObject\MockObject;
use ShoppingCart\Event\MercurePublisher\Application\NotifyOnCartUpdated;
use ShoppingCart\Event\MercurePublisher\Domain\Publisher;
use ShoppingCart\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

class NotifyOnCartUpdatedTest extends UnitTestCase
{
    private Publisher&MockObject $publisher;
    private NotifyOnCartUpdated $notifyOnCartUpdated;

    protected function setUp(): void
    {
        parent::setUp();

        $this->publisher = $this->getMockBuilder(Publisher::class)->getMock();
        $this->notifyOnCartUpdated = new NotifyOnCartUpdated($this->publisher);
    }

    public function testReceiveCartUpdatedEvent(): void
    {
        $event = CartUpdatedObjectMother::make();

        $this->publisher->expects($this->once())
            ->method('publish')
            ->with(
                $event->aggregateId,
                json_encode(['cartId' => $event->aggregateId, 'numberItems' => $event->attributes()['numberItems']]),
            );

        $this->notifyOnCartUpdated->dispatch($event);
    }
}
