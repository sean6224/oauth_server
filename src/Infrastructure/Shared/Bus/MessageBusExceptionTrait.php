<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

/**
 * Trait designed to handle exceptions from message bus.
 * This trait includes method to extract root cause of `HandlerFailedException`
 * and rethrow it, bypassing nested exceptions.
 *
 * Methods:
 * - `throwException(HandlerFailedException $exception)`: Extracts the root cause
 *   from `HandlerFailedException` by traversing the exception chain and throws it.
 *
 * Notes:
 * - Typically used in message-driven architectures where exceptions can be nested within
 *   `HandlerFailedException`.
 * - Provides clean way to rethrow the underlying cause of failure.
 *
 * Exception Handling:
 * - This method can throw various types of exceptions depending on the original cause.
 * - It can throw `Throwable`, as it might rethrow a different type of exception from the exception chain.
 *
 * @throws Throwable
 */
trait MessageBusExceptionTrait
{
    /**
     * @throws Throwable
     */
    public function throwException(HandlerFailedException $exception): void
    {
        $currentException = $exception;
        while ($currentException instanceof HandlerFailedException) {
            $previous = $currentException->getPrevious();
            if ($previous === null) {
                break;
            }
            $currentException = $previous;
        }

        throw $currentException;
    }
}
