<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Repository;

use App\Infrastructure\Shared\Repository\AbstractMysqlRepository;
use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\ValueObject\Purpose;
use App\Domain\Security\Repository\CheckUserSecurityByUuidInterface;
use App\Domain\Security\Repository\FindByCodeInterface;
use App\Domain\Security\Repository\FindUserByCodeInterface;
use App\Domain\Security\Repository\FindNonInvalidatedByUserUuidInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use App\Domain\User\Exception\UserNotFoundException;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a repository for managing security codes stored in MySQL.
 * It implements interfaces for checking user security by UUID, finding security codes by code,
 * and finding non-invalidated security codes by user UUID.
 *
 * Interfaces Implemented:
 * - `CheckUserSecurityByUuidInterface`: Provides methods for checking user security by UUID.
 * - `FindByCodeInterface`: Provides methods for finding security codes by code.
 * - `FindUserByCodeInterface`: Provides methods for finding a user UUID by security code and purpose.
 * - `FindNonInvalidatedByUserUuidInterface`: Provides methods for finding non-invalidated security codes by user UUID.
 *
 * Methods:
 * - `getClass()`: Returns the class name of the entity managed by this repository, which is `SecurityCode::class`.
 * - `securityCodeLimitExists(UuidInterface $uuid, int $limit)`: Checks if the user's security code limit exists.
 * - `findByCode(UuidInterface $userUuid, string $code)`: Finds a security code by its code and associated user UUID.
 * - `findUserBySecurity(string $code, string $purpose)`: Finds a user UUID by security code and purpose.
 * - `findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose)`: Finds a non-invalidated security code by its associated user UUID and purpose.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple results are returned for a query that expects a single result.
 * - `NoResultException`: Thrown if no results are returned for a query.
 * - `UserNotFoundException`: Thrown when a user UUID is not found for the given security code and purpose.
 */
class MysqlReadModelSecurityRepository extends AbstractMysqlRepository implements
    CheckUserSecurityByUuidInterface,
    FindByCodeInterface,
    FindUserByCodeInterface,
    FindNonInvalidatedByUserUuidInterface
{
    protected function getClass(): string
    {
        return SecurityCode::class;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function securityCodeLimitExists(UuidInterface $uuid, int $limit): bool
    {
        $qb = $this->repository->createQueryBuilder('sc');

        return (int) $qb->select('COUNT(sc.uuid)')
                ->innerJoin('sc.security', 's')
                ->where($qb->expr()->andX(
                    $qb->expr()->eq('s.userUuid', ':uuid'),
                    $qb->expr()->isNull('s.invalidateAt')
                ))
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getSingleScalarResult() >= $limit;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByCode(UuidInterface $userUuid, string $code): ?SecurityCode
    {
        $qb = $this->repository->createQueryBuilder('sc');

        return $qb->select('sc')
            ->innerJoin('sc.security', 's')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('s.userUuid', ':userUuid'),
                $qb->expr()->eq('sc.code', ':code')
            ))
            ->setParameter('userUuid', $userUuid->toString())
            ->setParameter('code', $code)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function findUserBySecurity(string $code, string $purpose): ?UuidInterface
    {
        $qb = $this->repository->createQueryBuilder('sc');

        $result = $qb->select('s.userUuid')
            ->innerJoin('sc.security', 's')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('sc.code', ':code'),
                $qb->expr()->eq('s.purposeCode', ':purpose')
            ))
            ->setParameter('code', $code)
            ->setParameter('purpose', $purpose)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$result) {
            throw new UserNotFoundException();
        }
        return $result['userUuid'];
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose): ?Security
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb->select('s')
            ->from(Security::class, 's')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('s.userUuid', ':userUuid'),
                $qb->expr()->eq('s.purposeCode', ':purposeCode'),
                $qb->expr()->isNull('s.invalidateAt')
            ))
            ->setParameter('userUuid', $userUuid->toString())
            ->setParameter('purposeCode', $purpose->value())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
