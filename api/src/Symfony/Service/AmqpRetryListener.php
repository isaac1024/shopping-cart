<?php

namespace App\Service;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceivedStamp;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Transport\TransportInterface;

final readonly class AmqpRetryListener implements EventSubscriberInterface
{
    public function __construct(private TransportInterface $retryTransport, private TransportInterface $failedTransport)
    {
    }

    public function onMessageFailed(WorkerMessageFailedEvent $event): void
    {
        $envelope = $event->getEnvelope();
        $amqpReceivedStamp = $envelope->last(AmqpReceivedStamp::class);
        if (!$amqpReceivedStamp) {
            return;
        }

        $this->send(
            $amqpReceivedStamp,
            $amqpReceivedStamp->getAmqpEnvelope()->getRoutingKey(),
            $amqpReceivedStamp->getAmqpEnvelope()->getHeaders()['x-retries'] ?? 0
        );
    }

    private function send(AmqpReceivedStamp $amqpReceivedStamp, string $eventType, int $retries): void
    {
        $envelope = new Envelope(new AmqpMessage($amqpReceivedStamp->getAmqpEnvelope()->getBody()));

        if ($retries < 3) {
            $amqpStamp = new AmqpStamp(sprintf("%s.retry", $eventType), AMQP_NOPARAM, [
                'type' => $eventType,
                'content_type' => 'application/json',
                'content_encoding' => 'utf-8',
                'message_id' => $amqpReceivedStamp->getAmqpEnvelope()->getMessageId(),
                'timestamp' => $amqpReceivedStamp->getAmqpEnvelope()->getTimestamp(),
                'headers' => ['x-retries' => $retries + 1],
            ]);
            $this->retryTransport->send($envelope->with($amqpStamp));

            return;
        }

        $amqpStamp = new AmqpStamp(sprintf("%s.failed", $eventType), AMQP_NOPARAM, [
            'type' => $eventType,
            'content_type' => 'application/json',
            'content_encoding' => 'utf-8',
            'message_id' => $amqpReceivedStamp->getAmqpEnvelope()->getMessageId(),
            'timestamp' => $amqpReceivedStamp->getAmqpEnvelope()->getTimestamp(),
        ]);
        $this->failedTransport->send($envelope->with($amqpStamp));
    }


    public static function getSubscribedEvents(): array
    {
        return [
            WorkerMessageFailedEvent::class => ['onMessageFailed', 50],
        ];
    }
}
