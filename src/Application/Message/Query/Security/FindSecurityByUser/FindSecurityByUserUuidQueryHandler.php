<?php
declare(strict_types=1);
namespace App\Application\Message\Query\Security\FindSecurityByUser;

use App\Domain\Security\Entity\Security;
use App\Infrastructure\Security\Repository\MysqlReadModelSecurityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * This class is a query handler for processing the `FindSecurityByUserUuidQuery`.
 * It implements the `MessageHandlerInterface` and uses repository to find security information by user UUID.
 *
 * Constructor Parameters:
 * - `MysqlReadModelSecurityRepository $repository`: The repository used to find security information from a database.
 *
 * Method:
 * - `__invoke(FindSecurityByUserUuidQuery $query)`: Processes the `FindSecurityByUserUuidQuery` to find security information by user UUID.
 *   It retrieves security information from the repository using the UUID and purpose from the query.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple results are found for the provided UUID.
 */
readonly class FindSecurityByUserUuidQueryHandler implements MessageHandlerInterface
{
    public function __construct(
        private MysqlReadModelSecurityRepository $repository
    ) {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(FindSecurityByUserUuidQuery $query): Security
    {
        return $this->repository->findNonInvalidatedByUserUuid($query->getUuid(), $query->getPurpose());
    }
}
