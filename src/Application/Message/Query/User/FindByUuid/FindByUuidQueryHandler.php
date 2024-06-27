<?php
declare(strict_types=1);
namespace App\Application\Message\Query\User\FindByUuid;

use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\User\Entity\User;
use App\Infrastructure\User\Repository\MysqlReadModelUserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * This class is a query handler for processing the `FindByUuidQuery`.
 * It implements the `MessageHandlerInterface` and uses repository to fetch user by their UUID.
 *
 * Constructor Parameters:
 * - `MysqlReadModelUserRepository $repository`: The repository used to fetch user data from a database.
 *
 * Method:
 * - `__invoke(FindByUuidQuery $query)`: Processes the `FindByUuidQuery` to find user by UUID.
 *   It retrieves the user from the repository using the UUID from a query.
 *
 * Exceptions:
 * - `NotFoundException`: Thrown if no user is found with the provided UUID.
 * - `NonUniqueResultException`: Thrown if multiple results are found for the provided UUID.
 */
readonly class FindByUuidQueryHandler implements MessageHandlerInterface
{
    public function __construct(
        private MysqlReadModelUserRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function __invoke(FindByUuidQuery $query): User
    {
        return $this->repository->oneByUuid($query->userUuid());
    }
}
