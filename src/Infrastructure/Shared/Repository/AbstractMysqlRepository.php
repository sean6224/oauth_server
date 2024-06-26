<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
/**
 *
 * This class is an abstract repository providing common operations for MySQL-based data access.
 * It uses Doctrine's `EntityManagerInterface` and `EntityRepository` to perform CRUD operations and query building.
 *
 * Constructor Parameters:
 * - `EntityManagerInterface $entityManager`: The entity manager for interacting with the database.
 *
 * Abstract Methods:
 * - `getClass()`: Returns the class name for the repository, to be implemented by subclasses.
 *
 * Methods:
 * - `save(object $entity)`: Persists the given entity to database.
 * - `apply()`: Flushes changes to database.
 * - `delete(object $entity)`: Removes the given entity from repository.
 * - `oneOrException(QueryBuilder $queryBuilder)`: Retrieves one entity or throws `NotFoundException` if no entity is found. Throws `NonUniqueResultException` if multiple entities are found.
 * - `setRepository(string $model)`: Sets the repository based on class name provided by `getClass()`.
 *
 * Exceptions:
 * - `NotFoundException`: Thrown if no entity is found when one is expected.
 * - `NonUniqueResultException`: Thrown if multiple entities are found when only one is expected.
 */
abstract class AbstractMysqlRepository
{
    protected EntityRepository $repository;
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->setRepository($this->getClass());
    }

    abstract protected function getClass(): string;

    /**
     * Save new entity to the repository.
     *
     * @param object $entity The entity to be persisted.
     */
    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    /**
     * Flush changes to the database.
     */
    public function apply(): void
    {
        $this->entityManager->flush();
    }

    /**
     * Remove an entity from the repository.
     *
     * @param object $entity The entity to be removed.
     */
    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
    }

    /**
     * Retrieve one entity or throw an exception if not found.
     *
     * @param QueryBuilder $queryBuilder The query builder for fetching the entity.
     *
     * @return object The entity.
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    protected function oneOrException(QueryBuilder $queryBuilder): object
    {
        $entity = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $entity) {
            throw new NotFoundException();
        }

        return $entity;
    }

    private function setRepository(string $model): void
    {
        $this->repository = $this->entityManager->getRepository($model);
    }
}
