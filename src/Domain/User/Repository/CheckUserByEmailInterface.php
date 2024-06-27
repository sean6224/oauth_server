<?php
declare(strict_types=1);
namespace App\Domain\User\Repository;

use App\Domain\User\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * This interface defines method to check if user with specific email exists in the repository.
 * It includes exception handling to account for cases where there are multiple or no results.
 *
 * Method:
 * - `emailExists(Email $email)`: Checks if user with the provided email exists.
 *   Returns `true` if a user is found with the given email, and `false` otherwise.
 *   Throws `NonUniqueResultException` if multiple users are found, and `NoResultException` if no user is found.
 *
 * Parameters for `emailExists`:
 * - `Email $email`: The email address to check for user existence.
 *
 * Returns:
 * - `bool`: Returns `true` if user with the provided email exists, and `false` otherwise.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple users are found with same email.
 * - `NoResultException`: Thrown if no user is found with the provided email.
 */
interface CheckUserByEmailInterface
{
    /**
     * Checks if user with the provided email exists.
     *
     * @param Email $email The email to check for user existence.
     * @return bool True if the user exists, false otherwise.
     * @throws NonUniqueResultException If multiple users are found with the same email.
     * @throws NoResultException If no user is found with the provided email.
     */
    public function emailExists(Email $email): bool;
}
