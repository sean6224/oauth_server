<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Repository;

use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\CheckUserByEmailInterface;
use App\Domain\User\Repository\GetUserByEmailInterface;
use App\Domain\User\Repository\GetUserByUuidInterface;
use App\Domain\User\Repository\GetUserUuidByEmailInterface;
use App\Domain\User\ValueObject\Email;
use App\Infrastructure\Shared\Repository\AbstractMysqlRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\UuidInterface;

/**
 * This class is a repository for accessing user data.
 * It implements multiple interfaces for checking users by email,
 * retrieving users by UUID, and getting user UUID by email.
 *
 * Interfaces Implemented:
 * - `CheckUserByEmailInterface`: Provides method to check if an email exists in the repository.
 * - `GetUserByUuidInterface`: Provides method to retrieve `User` by their UUID.
 * - `GetUserUuidByEmailInterface`: Provides method to get user UUID by email.
 *
 * Methods:
 * - `getClass()`: Returns the class name for the repository, typically `User::class`.
 * - `emailExists(Email $email)`: Checks if an email exists in the repository.
 * Returns `true` if email exists, `false` otherwise.
 * - `oneByUuid(UuidInterface $uuid)`: Retrieves `User` by their UUID.
 * Throw `NonUniqueResultException` if multiple users are found and `NoResultException` if no user is found.
 * - `getUuidByEmail(Email $email)`: Returns the UUID of user by email or `null` if no user is found.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple results are returned for a query that expects a single result.
 * - `NoResultException`: Thrown if no result is returned for a query.
 */
final class MysqlReadModelUserRepository extends AbstractMysqlRepository implements
    CheckUserByEmailInterface,
    GetUserByUuidInterface,
    GetUserUuidByEmailInterface,
    GetUserByEmailInterface
{
    private const EMAIL_CONDITION = 'user.email = :email';

    protected function getClass(): string
    {
        return User::class;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function emailExists(Email $email): bool
    {
        return 0 !== (int)$this->repository
                ->createQueryBuilder('user')
                ->select('count(1)')
                ->where(self::EMAIL_CONDITION)
                ->setParameter('email', (string)$email)
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * {@inheritDoc}
     */
    public function oneByUuid(UuidInterface $uuid): User
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $uuid->toString());
        return $this->oneOrException($qb);
    }

    /**
     * {@inheritDoc}
     */
    public function getUuidByEmail(Email $email): ?UuidInterface
    {
        $userId = $this->repository
            ->createQueryBuilder('user')
            ->select('user.uuid')
            ->where(self::EMAIL_CONDITION)
            ->setParameter('email', (string)$email)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
            ->getOneOrNullResult();

        return $userId['uuid'] ?? null;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function getUserByEmail(Email $email): User
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where(self::EMAIL_CONDITION)
            ->setParameter('email', (string)$email);

        return $this->oneOrException($qb);
    }
}
