<?php
declare(strict_types=1);
namespace App\Domain\Security\Entity;

use App\Domain\AggregateRootBehaviourTrait;
use App\Domain\AggregateRootInterface;
use App\Domain\Security\ValueObject\Code;
use App\Domain\Security\ValueObject\Status;
use App\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\UuidInterface;

/**
 * Represents security code associated with user's security entity.
 *
 * Attributes:
 * - `eventUuid`: The UUID of event associated with this security code.
 * - `code`: The security code string.
 * - `status`: The status of security code.
 * - `usedAt`: The date and time when security code was used (nullable).
 * - `Security`: The security entity associated with this security code.
 *
 * Methods:
 * - `setEvent(UuidInterface $eventUuid)`: Method to set the UUID of associated event.
 * - `getCode(): string`: Method to get the security code string.
 * - `setCode(string $code)`: Method to set the security code string.
 * - `getStatus(): string`: Method to get the status of security code.
 * - `setStatus(string $status)`: Method to set the status of security code.
 * - `getUsedAt(): ?DateTime`: Method to get the date and time when security code was used (nullable).
 * - `setUsedAt(?DateTime $usedAt)`: Method to set the date and time when security code was used (nullable).
 * - `getSecurity(): Security`: Method to get the security entity associated with this security code.
 * - `setSecurity(Security $security)`: Method to set the security entity associated with this security code.
 */
class SecurityCode implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private UuidInterface $eventUuid;
    private Code $code;
    private Status $status;
    private ?DateTime $usedAt;
    private Security $security;

    public function setEvent(UuidInterface $eventUuid): void
    {
        $this->eventUuid = $eventUuid;
    }

    public function getEvent(): UuidInterface
    {
        return $this->eventUuid;
    }
    public function getCode(): Code
    {
        return $this->code;
    }

    public function setCode(Code $code): void
    {
        $this->code = $code;
    }

    public function isUsed(): bool
    {
        return $this->status->isEqual(Status::fromString('used'));
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function getUsedAt(): ?DateTime
    {
        return $this->usedAt;
    }

    public function setUsedAt(?DateTime $usedAt): void
    {
        $this->usedAt = $usedAt;
    }

    public function getSecurity(): Security
    {
        return $this->security;
    }

    public function setSecurity(Security $security): void
    {
        $this->security = $security;
    }
}
