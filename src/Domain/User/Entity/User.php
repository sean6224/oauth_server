<?php
declare(strict_types=1);
namespace App\Domain\User\Entity;

use App\Domain\AggregateRootBehaviourTrait;
use App\Domain\AggregateRootInterface;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\HashedPassword;
use App\Domain\User\ValueObject\Username;

/**
 * This class represents a user entity with various attributes and domain events.
 * It implements the `AggregateRootInterface` and uses the `AggregateRootBehaviourTrait` for domain event handling and other aggregate root behaviors.
 *
 * Attributes:
 * - `username`: The `Username` of the user.
 * - `email`: The `Email` of the user.
 * - `password`: The `HashedPassword` of the user.
 * - `createdAt`: The `DateTime` when the user was created.
 * - `updatedAt`: The `DateTime` when the user was last updated.
 * - `loggedAt`: The `DateTime` when the user last logged in.
 * - `deletedAt`: Nullable `DateTime` indicating whether the user is soft-deleted.
 * - `suspendedAt`: Nullable `DateTime` indicating whether the user is suspended.
 *
 * Methods:
 * - `getUsername()`: Returns the `Username` of the user.
 * - `setUsername(Username $username)`: Sets the `Username` of the user.
 * - `getEmail()`: Returns the `Email` of the user.
 * - `getPassword()`: Returns the `HashedPassword` of the user.
 * - `setEmail(Email $email)`: Sets the user's email address.
 * - `setPassword(HashedPassword $password)`: Sets the user's password.
 * - `setCreatedAt(DateTime $createdAt)`: Sets the creation timestamp for the user.
 * - `setUpdatedAt(DateTime $updatedAt)`: Sets the last update timestamp for the user.
 * - `setLoggedAt(DateTime $loggedAt)`: Sets the last login timestamp for the user.
 * - `setSuspendedAt(?DateTime $suspendedAt)`: Sets the suspension timestamp for the user (nullable).
 * - `setDeletedAt(?DateTime $deletedAt)`: Sets the soft-deletion timestamp for the user (nullable).
 * - `isDeleted()`: Returns `true` if the user is soft-deleted, `false` otherwise.
 * - `isSuspended()`: Returns `true` if the user is suspended, `false` otherwise.
 *
 * Notes:
 * - This class is designed for domain-driven architectures and represents an aggregate root.
 * - The class manages significant user-related attributes and supports operations like updating email and handling domain events.
 */
class User implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private Username $username;
    public Email $email;
    public HashedPassword $password;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private DateTime $loggedAt;
    private ?DateTime $deletedAt = null;
    private ?DateTime $suspendedAt = null;

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function setUsername(Username $username): Username
    {
        return $this->username = $username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPassword(HashedPassword $password): void
    {
        $this->password = $password;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setLoggedAt(DateTime $loggedAt): void
    {
        $this->loggedAt = $loggedAt;
    }
    public function setSuspendedAt(?DateTime $suspendedAt): void
    {
        $this->suspendedAt = $suspendedAt;
    }
    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }

    public function isSuspended(): bool
    {
        return $this->suspendedAt !== null;
    }
}
