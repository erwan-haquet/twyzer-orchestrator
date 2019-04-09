<?php

namespace App\Serialization\Transport;

use App\Factory\MessageFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\InvalidArgumentException;
use Symfony\Component\Messenger\Stamp\SerializerStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

/**
 * This is an override of Symfony\Component\Messenger\Transport\Serialization\Serializer
 * Envelope headers now requires Action parameters to retrieve the right Message Class
 *
 * Class CustomSerializer
 * @package App\Transport\Serialization
 */
class ExternalMessageSerializer implements SerializerInterface
{
    private const STAMP_HEADER_PREFIX = 'X-Message-Stamp-';

    private $serializer;
    private $format;
    private $context;
    private $messageFactory;

    public function __construct(SymfonySerializerInterface $serializer = null, string $format = 'json', array $context = [])
    {
        $this->serializer = $serializer ?? self::create()->serializer;
        $this->format = $format;
        $this->context = $context;
        $this->messageFactory = new MessageFactory();
    }

    public static function create(): self
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer = new SymfonySerializer($normalizers, $encoders);

        return new self($serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body']) || empty($encodedEnvelope['headers'])) {
            throw new InvalidArgumentException('Encoded envelope should have at least a "body" and some "headers".');
        }

        if (empty($encodedEnvelope['headers']['action'])) {
            throw new InvalidArgumentException('Encoded envelope does not have an "action" header.');
        }

        if (!$messageClass = $this->messageFactory->getMessageClass($encodedEnvelope['headers']['action'])) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid action.', $encodedEnvelope['headers']['action']));
        }

        $stamps = $this->decodeStamps($encodedEnvelope);

        $context = $this->context;
        if (isset($stamps[SerializerStamp::class])) {
            $context = end($stamps[SerializerStamp::class])->getContext() + $context;
        }

        $message = $this->serializer->deserialize($encodedEnvelope['body'], $messageClass, $this->format, $context);

        return new Envelope($message, ...$stamps);
    }

    /**
     * {@inheritdoc}
     */
    public function encode(Envelope $envelope): array
    {
        $context = $this->context;
        /** @var SerializerStamp|null $serializerStamp */
        if ($serializerStamp = $envelope->last(SerializerStamp::class)) {
            $context = $serializerStamp->getContext() + $context;
        }

        $headers = ['type' => \get_class($envelope->getMessage())] + $this->encodeStamps($envelope);

        return [
            'body' => $this->serializer->serialize($envelope->getMessage(), $this->format, $context),
            'headers' => $headers,
        ];
    }

    private function decodeStamps(array $encodedEnvelope): array
    {
        $stamps = [];
        foreach ($encodedEnvelope['headers'] as $name => $value) {
            if (0 !== strpos($name, self::STAMP_HEADER_PREFIX)) {
                continue;
            }

            $stamps[] = $this->serializer->deserialize($value, substr($name, \strlen(self::STAMP_HEADER_PREFIX)).'[]', $this->format, $this->context);
        }
        if ($stamps) {
            $stamps = array_merge(...$stamps);
        }

        return $stamps;
    }

    private function encodeStamps(Envelope $envelope): array
    {
        if (!$allStamps = $envelope->all()) {
            return [];
        }

        $headers = [];
        foreach ($allStamps as $class => $stamps) {
            $headers[self::STAMP_HEADER_PREFIX.$class] = $this->serializer->serialize($stamps, $this->format, $this->context);
        }

        return $headers;
    }
}
