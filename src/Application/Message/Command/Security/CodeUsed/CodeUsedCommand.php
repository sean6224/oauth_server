<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\CodeUsed;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a command to generate security code for various purposes.
 * It implements the `CommandInterface` and encapsulates the UUID of the user and various parameters for generating the security code.
 *
 * Constructor Parameters:
 * - `string $uuid`: The UUID of user for whom security code is generated.
 * - `string $purpose`: The purpose for used security code (e.g., password reset, email verification).
 * - `String $code`: The code for used security code.
 *
 * Methods:
 * - `userUuid()`: Returns the UUID of the user for whom security code is used.
 * - `getPurpose()`: Returns the purpose for used security code.
 * - `getCode()`: Returns the code for used security code.
 */
final class CodeUsedCommand implements CommandInterface
{
    private UuidInterface $userUuid;

    public function __construct(
        UuidInterface $userUuid,
        private readonly string $purpose,
        private readonly string $code,
    ) {
        $this->userUuid = $userUuid;
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getPurpose(): string
    {
        return $this->purpose;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
