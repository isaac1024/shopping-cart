<?php

declare(strict_types=1);

namespace ShoppingCart\Tests\Shared\Infrastructure\PhpUnit;

use ReflectionClass;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Exporter\Exporter;
use ShoppingCart\Shared\Domain\Bus\DomainEvent;

final class EventComparator extends Comparator
{
    private const IGNORE_PROPERTIES = ['eventId', 'occurredOn'];

    public function accepts($expected, $actual): bool
    {
        return $expected instanceof DomainEvent && $actual instanceof DomainEvent;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false): void
    {
        $this->recursiveComparator($expected, $actual);
    }

    public function recursiveComparator($expected, $actual): void
    {
        $exporter = new Exporter();
        if ($actual::class !== $expected::class) {
            $expectedExported = $exporter->export($expected);
            $actualExported = $exporter->export($actual);
            throw new ComparisonFailure(
                $expected,
                $actual,
                $expectedExported,
                $actualExported,
                sprintf('%s is not instance of expected class "%s".', $actualExported, $expected::class),
            );
        }

        $reflectionClass = new ReflectionClass($expected);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            if (in_array($reflectionProperty->getName(), self::IGNORE_PROPERTIES, true)) {
                continue;
            }

            $reflectionProperty->setAccessible(true);

            $expectedValue = $reflectionProperty->getValue($expected);
            $actualValue = $reflectionProperty->getValue($actual);

            if (is_object($expectedValue)) {
                $this->recursiveComparator($expectedValue, $actualValue);
                continue;
            }

            if ($expectedValue !== $actualValue) {
                throw new ComparisonFailure(
                    $expected,
                    $actual,
                    $exporter->export($expected),
                    $exporter->export($actual),
                    'Failed asserting that two objects are equal.',
                );
            }
        }
    }
}
