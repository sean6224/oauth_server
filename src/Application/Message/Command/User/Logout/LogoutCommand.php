<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\Logout;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents command to log out user.
 * It implements the `CommandInterface` and encapsulates UUID of user to be logged out.
 *
 * Constructor Parameters:
 * - `UuidInterface $userUuid`: The UUID of user to be logged out.
 *
 * Method:
 * - `getUuid()`: Returns the UUID of user to be logged out.
 */
final readonly class LogoutCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $userUuid,
    ) {
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }
}
