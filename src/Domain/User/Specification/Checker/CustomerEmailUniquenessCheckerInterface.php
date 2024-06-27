<?php
declare(strict_types=1);
namespace App\Domain\User\Specification\Checker;

use App\Domain\User\ValueObject\Email;

/**
 * This interface provides contract for checking the uniqueness of customer email addresses.
 * Implementing classes should provide a mechanism to determine if a given email address is unique within specific context, like database or other storage system.
 *
 * Method:
 * - `isUnique(Email $email)`: Checks whether the provided email is unique. Returns `true` if the email is unique, and `false` otherwise.
 *
 * Parameters:
 * - `email`: The `Email` object representing the email address to check for uniqueness.
 *
 * Return Value:
 * - `bool`: The method returns `true` if the email is unique, indicating no other customer is using it, and `false` if it's already in use.
 */
interface CustomerEmailUniquenessCheckerInterface
{
    public function isUnique(Email $email): bool;
}
