<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Repository;

use App\Infrastructure\Shared\Repository\AbstractMysqlRepository;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\Shared\Exception\NotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class for storing user entities using Doctrine ORM.
 */
class DoctrineUserStore extends AbstractMysqlRepository implements UserRepositoryInterface
{
    protected function getClass(): string
    {
        return User::class;
    }

    /**
     * Retrieve user by their UUID.
     *
     * @param UuidInterface $uuid The UUID of user.
     * @return User The User Object.
     * @throws NotFoundException If no user is found with the given UUID.
     * @throws NonUniqueResultException If multiple results are found when only one was expected.
     */
    public function get(UuidInterface $uuid): User
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('user.uuid = :uuid')
            ->setParameter('uuid', $uuid->toString());

        return $this->oneOrException($qb);
    }

    /**
     * Store (persist) given user to the repository.
     *
     * @param User $user The User Object to be stored.
     */
    public function store(User $user): void
    {
        $this->save($user);
        $this->apply();
    }
}
