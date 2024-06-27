<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\InvalidateCode;

use App\Domain\User\ValueObject\Security\Purpose;
use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a command to invalidate the security code for various purposes.
 * It implements the `CommandInterface` and encapsulates the UUID of the user and the purpose for invalidating the security code.
 *
 * Constructor Parameters:
 * - `UuidInterface $userUuid`: The UUID of the user for whom the security code is invalidated.
 * - `string $purpose`: The purpose for which the security code is invalidated (e.g., password reset, email verification).
 *
 * Methods:
 * - `userUuid()`: Returns the UUID of the user for whom the security code is invalidated.
 * - `getPurpose()`: Returns the purpose for which the security code is invalidated.
 */
final class InvalidateCodeCommand implements CommandInterface
{
    private UuidInterface $userUuid;
    private Purpose $purpose;

    public function __construct(
        UuidInterface $userUuid,
        string $purpose,
    ) {
        $this->userUuid = $userUuid;
        $this->purpose = Purpose::fromString($purpose);
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getPurpose(): Purpose
    {
        return $this->purpose;
    }
}
