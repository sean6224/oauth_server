<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ChangeEmail;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;
use App\Domain\User\ValueObject\Email;

/**
 * This class represents command to change user's email address.
 * It implements the `CommandInterface` and encapsulates the user UUID and new email address.
 *
 * Attributes:
 * - `userUuid`: A `UuidInterface` representing the UUID of the user whose email is being changed.
 * - `email`: An `Email` value object representing the new email address for user.
 *
 * Constructor:
 * - `__construct(UuidInterface $userUuid, Email $email)`: Initializes the command with user UUID and new email address.
 *   Converts the `userUuid` to `UuidInterface` and the `email` to an `Email` value object.
 *
 * Methods:
 * - `userUuid()`: Returns the UUID of user.
 * - `email()`: Returns the `Email` value object representing new email address.
 *
 * Notes:
 * - This command is typically used in a command-driven architecture to trigger change in user's email address.
 * - The `CommandInterface` implementation allows for compatibility with a command bus or other command-oriented processing.
 */
final class ChangeEmailCommand implements CommandInterface
{
    private Email $email;
    public function __construct(
        private readonly UuidInterface $userUuid,
        string $email
    ) {
        $this->email = Email::fromString($email);
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function email(): Email
    {
        return $this->email;
    }
}
