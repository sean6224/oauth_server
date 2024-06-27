<?php
declare(strict_types=1);
namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;
use Ramsey\Uuid\UuidInterface;

/**
 * This interface defines methods for retrieving and storing user entities in repository.
 * It includes operations to get user by UUID and to store user.
 *
 * Methods:
 * - `get(UuidInterface $uuid)`: Retrieves `User` by its UUID.
 *   Returns `User` corresponding to provided UUID.
 * - `store(User $user)`: Stores the provided `User` entity. This operation typically persists changes to repository.
 *
 * Parameters:
 * - `UuidInterface $uuid`: The UUID of user to retrieve.
 * - `User $user`: The user entity to store.
 *
 * Returns:
 * - `User`: The retrieved user entity for the `get` method.
 * - `void`: The `store` method does not return a value.
 */
interface UserRepositoryInterface
{
    /**
     * Retrieves user by its UUID.
     *
     * @param UuidInterface $uuid The UUID of the user.
     * @return User The retrieved user.
     */
    public function get(UuidInterface $uuid): User;

    /**
     * Stores user.
     *
     * @param User $user The user to store.
     * @return void
     */
    public function store(User $user): void;
}
