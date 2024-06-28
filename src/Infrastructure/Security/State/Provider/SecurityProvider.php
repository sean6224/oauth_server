<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Application\DTO\Security\Output\SecurityView;
use App\Application\Message\Query\Security\FindSecurityByUser\FindSecurityByUserUuidQuery;
use App\Domain\Security\ValueObject\Purpose;
use App\Infrastructure\Shared\Bus\Query\QueryBus;
use Throwable;

/**
 * This class provides security information for a given user.
 * It implements the `ProviderInterface` to fetch security data through a query bus.
 *
 * Constructor:
 * - `__construct(QueryBus $queryBus)`: Initializes the provider with a query bus.
 *
 * Methods:
 * - `provide(Operation $operation, array $uriVariables = [], array $context = [])`: Fetches security data for the specified user UUID.
 *
 * Exceptions:
 * - `Throwable`: Thrown if any error occurs during the query handling process.
 */
readonly class SecurityProvider implements ProviderInterface
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
        $purpose = Purpose::fromString($context['filters']['purpose']);
        $query = new FindSecurityByUserUuidQuery($uriVariables['uuid'], $purpose);
        return SecurityView::create($this->queryBus->handle($query));
    }
}
