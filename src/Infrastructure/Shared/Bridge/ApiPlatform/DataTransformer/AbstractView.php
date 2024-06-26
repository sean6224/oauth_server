<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bridge\ApiPlatform\DataTransformer;

/**
 * Abstract class representing a view data transformer.
 * Provides a static method `create` to instantiate an instance of the implementing class.
 *
 * Methods:
 * - `create(object $object): self`: Static method to create an instance of the implementing class based on an object.
 */
abstract class AbstractView
{
    abstract public static function create(object $object): self;
}
