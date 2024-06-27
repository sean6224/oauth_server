<?php
declare(strict_types=1);
namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;

/**
 * This interface defines method to retrieve user by their email address.
 * It includes exception handling to account for cases where the user is not found.
 *
 * Method:
 * - `getUserByEmail(Email $email)`: Retrieves user by their email address.
 *   Throw `UserNotFoundException` if no user is found with the given email address.
 *
 * Parameters for `getUserByEmail`:
 * - `Email $email`: The email address of the user to retrieve.
 *
 * Returns:
 * - `User`: The user entity corresponding to the provided email address.
 *
 * Exceptions:
 * - `UserNotFoundException`: Thrown if no user is found with the given email address.
 */
interface GetUserByEmailInterface
{
    public function getUserByEmail(Email $email): User;
}
