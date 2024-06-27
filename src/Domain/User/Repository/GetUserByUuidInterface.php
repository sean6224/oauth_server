<?php
declare(strict_types=1);
namespace App\Domain\User\Repository;

use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\User\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

/**
 * This interface defines method to retrieve `User` by their UUID.
 * It includes exception handling to account for cases where user is not found or if there's non-unique result.
 *
 * Method:
 * - `oneByUuid(UuidInterface $uuid)`: Retrieves `User` by their UUID.
 *   Throws `NotFoundException` if no user is found with the given UUID, and `NonUniqueResultException` if multiple results are returned.
 *
 * Parameters for `oneByUuid`:
 * - `UuidInterface $uuid`: The UUID of the user to retrieve.
 *
 * Returns:
 * - `User`: The user entity corresponding to the provided UUID.
 *
 * Exceptions:
 * - `NotFoundException`: Thrown if no user is found with the given UUID.
 * - `NonUniqueResultException`: Thrown if more than one user is found with the given UUID.
 */
interface GetUserByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     *
     * @return User
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function oneByUuid(UuidInterface $uuid): User;
}
