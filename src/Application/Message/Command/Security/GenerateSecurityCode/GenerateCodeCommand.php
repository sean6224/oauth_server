<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\GenerateSecurityCode;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a command to generate security code for various purposes.
 * It implements the `CommandInterface` and encapsulates the UUID of the user and various parameters for generating the security code.
 *
 * Constructor Parameters:
 * - `string $uuid`: The UUID of user for whom security code is generated.
 * - `string $purpose`: The purpose for generating security code (e.g., password reset, email verification).
 * - `int $codeLength`: The length of generated security code.
 * - `string $deliveryMethod`: The method of delivering security code (e.g., email, SMS).
 * - `String $securityLevel`: The security level for generated code (e.g., low, medium, high).
 *
 * Methods:
 * - `userUuid()`: Returns the UUID of the user for whom security code is generated.
 * - `getPurpose()`: Returns the purpose for generating the security code.
 * - `getCodeLength()`: Returns the length of the generated security code.
 * - `getDeliveryMethod()`: Returns the method of delivering security code.
 * - `getSecurityLevel()`: Returns the security level of generated code.
 */
final class GenerateCodeCommand implements CommandInterface
{
    private UuidInterface $userUuid;

    public function __construct(
        UuidInterface $userUuid,
        private readonly string $purpose,
        private readonly int $codeLength,
        private readonly string $deliveryMethod,
        private readonly string $securityLevel,
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

    public function getCodeLength(): int
    {
        return $this->codeLength;
    }

    public function getDeliveryMethod(): string
    {
        return $this->deliveryMethod;
    }

    public function getSecurityLevel(): string
    {
        return $this->securityLevel;
    }
}
