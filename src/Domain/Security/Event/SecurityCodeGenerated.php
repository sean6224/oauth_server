<?php
declare(strict_types=1);
namespace App\Domain\Security\Event;

use App\Domain\Security\ValueObject\Purpose;
use App\Domain\Security\ValueObject\Status;
use App\Domain\Shared\Event\DomainEventInterface;
use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a domain event indicating that security code has been generated.
 * It implements the `DomainEventInterface` and includes information about the generated codes, their status, and related metadata.
 *
 * Attributes:
 * - `UuidInterface $userUuid`: The UUID of user for whom codes were generated.
 * - `UuidInterface $uuid`: The UUID of this domain event.
 * - `Purpose $purpose`: Purpose of the code (password reset, etc.).
 * - `DateTime $createdAt`: The date and time when the codes were generated.
 * - `DateTime $expirationTime`: The expiration time for the generated codes.
 * - `ArrayCollection $codes`: A collection of generated security codes.
 * - `Status $status`: The status of the generated codes, typically 'unused'.
 * - `DateTime|null $usedAt`: The date and time when the codes were used, or `null` if not yet used.
 *
 * Constructor:
 * - `__construct(UuidInterface $userUuid, array $codes, string $purposeType)`: Initializes the domain event with the user UUID, the generated codes and default status.
 *   It creates new UUID for the event, sets the current date-time as `createdAt`, and calculates the `expirationTime` as one month from `createdAt`.
 *
 * Exceptions:
 * - `DateTimeException`: Can be thrown if there's an error while setting the `createdAt` or `expirationTime`.
 */
final class SecurityCodeGenerated implements DomainEventInterface
{
    public UuidInterface $uuid;
    public Purpose $purpose;
    public DateTime $createdAt;
    public DateTime $expirationAt;

    public array $codes;
    public Status $status;
    public ?DateTime $usedAt = null;

    /**
     * @throws DateTimeException
     */
    public function __construct(
        public UuidInterface $userUuid,
        array $code,
        string $purposeType
    ) {
        $this->uuid = Uuid::uuid4();
        $this->codes = $code;
        $this->purpose = Purpose::fromString($purposeType);
        $this->status = Status::fromString('unused');
        $this->createdAt = DateTime::now();
        $this->expirationAt = $this->createdAt->modify('+1 month');
    }
}
