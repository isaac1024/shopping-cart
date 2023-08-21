<?php

namespace ShoppingCart\Shared\Infrastructure\Bus;

use App\Service\AmqpMessage;
use ShoppingCart\Shared\Domain\Bus\DomainEvent;
use ShoppingCart\Shared\Domain\Bus\EventBus;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;

final readonly class SymfonyEventBus implements EventBus
{
    public function __construct(private TransportInterface $transport)
    {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $envelope = new Envelope(new AmqpMessage(json_encode($this->getBody($event))));
            $this->transport->send($envelope->with(new AmqpStamp($event->type(), AMQP_NOPARAM, [
                'type' => $event->type(),
                'content_type' => 'application/json',
                'content_encoding' => 'utf-8',
                'message_id' => $event->eventId,
                'timestamp' => $event->occurredOn->getTimestamp(),
            ])));
        }
    }

    private function getBody(DomainEvent $event): array
    {
        return [
            'id' => $event->eventId,
            'data' => [
                'id' => $event->aggregateId,
                'type' => $event->type(),
                'attributes' => $event->attributes(),
            ],
            'occurredOn' => DateTimeUtils::format($event->occurredOn),
        ];
    }
}
