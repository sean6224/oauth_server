<?php
declare(strict_types=1);
namespace App\Domain\Security\Entity;

use App\Domain\AggregateRootBehaviourTrait;
use App\Domain\AggregateRootInterface;
use App\Domain\Security\ValueObject\Purpose;
use App\Domain\Shared\ValueObject\DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

/**
 * Represents security entity associated with user.
 *
 * Attributes:
 * - `userUuid`: The UUID of user associated with this security.
 * - `purposeCode`: The purpose type of the security.
 * - `createdAt`: The date and time when this security entity was created.
 * - `expirationAt`: The date and time when this security entity will expire (nullable).
 * - `invalidateAt`: The date and time when this security entity was invalidated (nullable).
 * - `securityCodes`: A collection of security codes associated with this security entity.
 *
 * Methods:
 * - `__construct()`: Constructor to initialize the security entity.
 * - `setUserUuid(UuidInterface $userUuid)`: Sets the UUID of associated user.
 * - `setPurposeType(Purpose $purposeCode)`: Sets the purpose type of security.
 * - `setCreatedAt(DateTime $createdAt)`: Sets the creation date and time.
 * - `setExpirationAt(?DateTime $expirationAt)`: Sets the expiration date and time (nullable).
 * - `setInvalidateAt(?DateTime $invalidateAt)`: Sets the invalidation date and time (nullable).
 * - `getUuid()`: Returns the UUID of this security entity.
 * - `getUserUuid()`: Returns the UUID of the associated user.
 * - `getPurposeType()`: Returns the purpose type of security.
 * - `getCreatedAt()`: Returns the creation date and time.
 * - `getExpirationAt()`: Returns the expiration date and time (nullable).
 * - `getInvalidateAt()`: Returns the invalidation date and time (nullable).
 * - `getSecurityCodes()`: Returns the collection of security codes associated with this security entity.
 * - `addSecurityCode(SecurityCode $securityCode)`: Adds security code to this security entity.
 */
class Security implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private UuidInterface $userUuid;
    private Purpose $purposeCode;
    private DateTime $createdAt;
    private ?DateTime $expirationAt;
    private ?DateTime $invalidateAt;
    /** @var Collection<int, SecurityCode> */
    private Collection $securityCodes;

    public function __construct()
    {
        $this->securityCodes = new ArrayCollection();
    }

    public function setUserUuid(UuidInterface $userUuid): void
    {
        $this->userUuid = $userUuid;
    }

    public function setPurposeType(Purpose $purposeCode): void
    {
        $this->purposeCode = $purposeCode;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setExpirationAt(DateTime $expirationAt): void
    {
        $this->expirationAt = $expirationAt;
    }
    public function setInvalidateAt(DateTime $invalidateAt): void
    {
        $this->invalidateAt = $invalidateAt;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getUserUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function getPurposeType(): Purpose
    {
        return $this->purposeCode;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getExpirationAt(): ?DateTime
    {
        return $this->expirationAt;
    }

    public function getInvalidateAt(): ?DateTime
    {
        return $this->invalidateAt;
    }

    /**
     * @return Collection<SecurityCode>
     */
    public function getSecurityCodes(): Collection
    {
        return $this->securityCodes;
    }

    public function addSecurityCode(SecurityCode $securityCode): void
    {
        if (!$this->securityCodes->contains($securityCode)) {
            $this->securityCodes->add($securityCode);
            $securityCode->setSecurity($this);
        }
    }
}
