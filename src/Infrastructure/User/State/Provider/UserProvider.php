<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Provider;

use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\Operation;
use App\Infrastructure\Shared\Bus\Query\QueryBus;
use App\Application\Message\Query\User\FindByUuid\FindByUuidQuery;
use App\Application\DTO\User\Output\UserView;
use Throwable;

/**
 * This class is a data provider for fetching user information.
 * It implements the `ProviderInterface` and uses `QueryBus` to process `FindByUuidQuery`.
 *
 * Constructor Parameters:
 * - `QueryBus $queryBus`: The query bus used to dispatch queries and fetch user data.
 *
 * Method:
 * - `provide(Operation $operation, array $uriVariables = [], array $context = [])`: Provides user information based on the `uuid` from `uriVariables`.
 *   It creates `FindByUuidQuery` and dispatches it through the `queryBus`, returning the result.
 *
 * Parameters for `provide`:
 * - `Operation $operation`: Represents the operation for which data is being provided.
 * - `array $uriVariables`: Contains the UUID for the user to fetch.
 * - `Array $context`: Additional context for the data providing operation.
 *
 * Returns:
 * - `object|array|null`: The result of the query, which could be an object, an array, or null if no user is found.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during the query process.
 *
 * Notes:
 * - The `QueryBus` is used to dispatch the `FindByUuidQuery` and return the user data.
 */
readonly class UserProvider implements ProviderInterface
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $query = new FindByUuidQuery($uriVariables['uuid']);
        return UserView::create($this->queryBus->handle($query));
    }
}
