<?php
declare(strict_types=1);
namespace App\Domain\Shared\ValueObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

abstract class ArrayValue
{
    private Collection $collection;

    protected function __construct(array $elements, private readonly string $className)
    {
        $this->ensureHasValidElementClass($className);
        $this->ensureElementsAreValidType($elements);

        $this->collection = new ArrayCollection($elements);
    }

    public static function fromArray(array $elements, string $className): static
    {
        $pushTypes = array_map(static fn($el) => new $className($el), $elements);
        return new static($pushTypes, $className);
    }

    public function toArray(): array
    {
        return $this->collection->toArray();
    }

    public function add(mixed $element): void
    {
        $this->ensureElementAreValidType($element);

        $this->collection->add($element);
    }

    public function remove(mixed $element): void
    {
        $this->ensureElementAreValidType($element);

        $this->collection->removeElement($element);
    }

    private function ensureHasValidElementClass(string $elementClass): void
    {
        if (!class_exists($elementClass)) {
            throw new InvalidArgumentException(sprintf('Collection object need valid element class, "%s" given.', $elementClass));
        }
    }

    private function ensureElementsAreValidType(iterable $elements): void
    {
        foreach ($elements as $element) {
            $this->ensureElementAreValidType($element);
        }
    }

    private function ensureElementAreValidType(mixed $element): void
    {
        if (!($element instanceof $this->className)) {
            throw new InvalidArgumentException('Each element must be an instance of '. $this->className);
        }
    }
}

