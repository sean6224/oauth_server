<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Repository;

use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\Repository\CheckUserSecurityByUuidInterface;
use App\Domain\Security\Repository\FindByCodeInterface;
use App\Domain\Security\Repository\FindNonInvalidatedByUserUuidInterface;
use App\Domain\Security\ValueObject\Purpose;
use App\Infrastructure\Shared\Repository\AbstractMysqlRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a repository for managing security codes stored in MySQL.
 * It implements interfaces for checking user security by UUID, finding security codes by code,
 * and finding non-invalidated security codes by user UUID.
 *
 * Interfaces Implemented:
 * - `CheckUserSecurityByUuidInterface`: Provides methods for checking user security by UUID.
 * - `FindByCodeInterface`: Provides methods for finding security codes by code.
 * - `FindNonInvalidatedByUserUuidInterface`: Provides methods for finding non-invalidated security codes by user UUID.
 *
 * Methods:
 * - `getClass()`: Returns the class name of the entity managed by this repository, which is `SecurityCode::class`.
 * - `securityCodeLimitExists(UuidInterface $uuid, int $limit)`: Checks if the user's security code limit exists.
 * - `findByCode(UuidInterface $userUuid, string $code)`: Finds a security code by its code and associated user UUID.
 * - `findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose)`: Finds a non-invalidated security code by its associated user UUID and purpose.
 *
 * Exceptions:
 * - `NonUniqueResultException`: Thrown if multiple results are returned for a query that expects a single result.
 * - `NoResultException`: Thrown if no results are returned for a query.
 */
class MysqlReadModelSecurityRepository extends AbstractMysqlRepository implements
    CheckUserSecurityByUuidInterface,
    FindByCodeInterface,
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
        $result = $this->repository
            ->createQueryBuilder('sc')
            ->select('COUNT(sc.uuid)')
            ->innerJoin('sc.security', 's')
            ->where('s.userUuid = :uuid')
            ->andWhere('s.invalidateAt IS NULL')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getSingleScalarResult();

        return $result >= $limit;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByCode(UuidInterface $userUuid, string $code): ?SecurityCode
    {
        $queryBuilder = $this->repository->createQueryBuilder('sc');
        $queryBuilder->select('sc')
            ->innerJoin('sc.security', 's')
            ->where('s.userUuid = :userUuid')
            ->andWhere('sc.code = :code')
            ->setParameter('userUuid', $userUuid->toString())
            ->setParameter('code', $code)
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose): ?Security
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('s')
            ->from(Security::class, 's')
            ->where('s.userUuid = :userUuid')
            ->andWhere('s.purposeCode = :purposeCode')
            ->andWhere('s.invalidateAt IS NULL')
            ->setParameter('userUuid', $userUuid->toString())
            ->setParameter('purposeCode', $purpose->value())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
