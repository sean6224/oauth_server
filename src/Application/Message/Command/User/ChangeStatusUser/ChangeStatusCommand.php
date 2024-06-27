<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ChangeStatusUser;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents command to change user's status.
 * It implements the `CommandInterface` and encapsulates user UUID, security code, and the type of operation to perform.
 *
 * Constructor Parameters:
 * - `UuidInterface $userUuid`: The UUID of user whose status is being changed.
 * - `string $securityCode`: A security code for validating the status change request.
 * - `string $operationType`: The type of operation to perform (e.g., "suspend", "soft_delete", "restore").
 *
 * Methods:
 * - `userUuid()`: Returns the UUID of user whose status is being changed.
 * - `securityCode()`: Returns the security code for validating the operation.
 * - `getOperationType()`: Returns the type of operation to be performed.
 */
final readonly class ChangeStatusCommand implements CommandInterface
{
    public function __construct(
        private UuidInterface $userUuid,
        private string $securityCode,
        private string $operationType
    ) {}

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function securityCode(): string
    {
        return $this->securityCode;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }
}
