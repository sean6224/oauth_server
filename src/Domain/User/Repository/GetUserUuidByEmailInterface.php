<?php
declare(strict_types=1);
namespace App\Domain\User\Repository;

use App\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * This interface defines method to retrieve the UUID of user based on their email address.
 * It includes exception handling to account for cases where there are multiple results for a given email.
 *
 * Method:
 * - `getUuidByEmail(Email $email)`: Retrieves the UUID of user with the provided email.
 *   Returns the UUID as `UuidInterface`, or `null` if no user is found.
 *   Throws `NonUniqueResultException` if multiple users are found with the same email.
 *
 * Parameters for `getUuidByEmail`:
 * - `Email $email`: The email address to search for user.
 *
 * Returns:
 * - `UuidInterface|null`: The UUID of the user with the given email, or `null` if not found.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple users are found with same email.
 */
interface GetUserUuidByEmailInterface
{
    /**
     * Retrieves the UUID of user with provided email.
     *
     * @param Email $email The email of user.
     * @return UuidInterface|null The UUID of user, or null if not found.
     * @throws NonUniqueResultException If multiple users are found with the same email.
     */
    public function getUuidByEmail(Email $email): ?UuidInterface;
}
