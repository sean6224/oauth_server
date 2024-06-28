<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Specification;

use App\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use App\Domain\User\Repository\CheckUserByEmailInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\Shared\Exception\EmailAlreadyExistException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Checks the uniqueness of customer email addresses.
 *
 * This class implements the CustomerEmailUniquenessCheckerInterface to provide a mechanism
 * for checking the uniqueness of customer email addresses.
 */
final readonly class CustomerEmailUniquenessChecker implements CustomerEmailUniquenessCheckerInterface
{
    public function __construct(
        private CheckUserByEmailInterface $checkUserByEmail
    ) {}

    /**
     * Checks if the provided email is unique.
     *
     * @param Email $email The email to check for uniqueness.
     * @return bool True if the email is unique, false otherwise.
     * @throws EmailAlreadyExistException If the email already exists in the database.
     * @throws NoResultException If there is no result found during the uniqueness check.
     */
    public function isUnique(Email $email): bool
    {
        try {
            if ($this->checkUserByEmail->emailExists($email)) {
                throw new EmailAlreadyExistException();
            }
        } catch (NonUniqueResultException) {
            throw new EmailAlreadyExistException();
        }

        return true;
    }
}
