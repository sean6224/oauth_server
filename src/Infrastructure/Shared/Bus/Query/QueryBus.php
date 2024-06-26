<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bus\Query;

use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

/**
 * This class represents query bus used to handle query messages.
 * It uses `MessageBusInterface` to dispatch queries and retrieve results through `HandledStamp`.
 *
 * Constructor Parameters:
 * - `MessageBusInterface $messageBus`: The message bus interface for dispatching query messages.
 *
 * Methods:
 * - `handle(QueryInterface $query)`: Dispatches the provided query to the message bus and returns the result.
 *   It uses `HandledStamp` to retrieve the outcome of dispatched query. If `HandlerFailedException` occurs, it uses `MessageBusExceptionTrait` to throw the underlying exception.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during query handling.
 *
 * Notes:
 * - This class is designed for message-driven architectures, where queries are dispatched to message bus for processing.
 * - The `HandledStamp` is used to extract the result from the dispatched query.
 * - The `MessageBusExceptionTrait` is used to handle exceptions, extracting the root cause from `HandlerFailedException`.
 * - Proper exception handling ensures accurate error reporting and debugging when processing queries.
 */
final class QueryBus
{
    use MessageBusExceptionTrait;

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {}

    /**
     * @param QueryInterface $query
     * @return mixed
     * @throws Throwable
     */
    public function handle(QueryInterface $query): mixed
    {
        try {
            $envelope = $this->messageBus->dispatch($query);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
