<?php

namespace App\Service;

use ShoppingCart\Shared\Domain\Bus\DomainEvent;
use ShoppingCart\Shared\Domain\Bus\Event;
use ShoppingCart\Shared\Domain\Models\DateTimeUtils;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class JsonAmqpSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        return new Envelope(new AmqpMessage($encodedEnvelope['body']));
    }

    public function encode(Envelope $envelope): array
    {
        $event = $envelope->getMessage();
        $body = $this->isEvent($event) ? json_encode($this->getBody($event)) : (string)$event;

        return ['headers' => [], 'body' => $body];
    }

    private function getBody(DomainEvent|Event $event): array
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

    private function isEvent($event): bool
    {
        return $event instanceof DomainEvent || $event instanceof Event;
    }
}
