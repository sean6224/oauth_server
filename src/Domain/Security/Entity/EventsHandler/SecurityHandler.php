<?php
declare(strict_types=1);
namespace App\Domain\Security\Entity\EventsHandler;

use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\Event\SecurityCodeGenerated;
use App\Domain\Security\Event\SecurityCodeUsed;
use App\Domain\Security\Event\SecurityInvalidateCodes;
use App\Domain\Security\ValueObject\Code;
use App\Domain\Security\ValueObject\Status;
use Ramsey\Uuid\Uuid;

/**
 * Handles events related to security operations for user entities.
 *
 * Methods:
 * - `securityCodeGenerated(SecurityCodeGenerated $event, Security $security)`:
 * Handles the event when a security code is generated.
 * - `securityCodeUsed(SecurityCodeUsed $event, SecurityCode $entity)`: Handles the event when a security code is used.
 * - `securityCodeInvalidated(SecurityInvalidateCodes $event, Security $entity)`:
 * Handles the event when security codes are invalidated.
 */
class SecurityHandler
{
    public function securityCodeGenerated(SecurityCodeGenerated $event, Security $security): void
    {
        $security->setUuid($event->uuid);
        $security->setUserUuid($event->userUuid);
        $security->setPurposeType($event->purpose);
        $security->setCreatedAt($event->createdAt);
        $security->setExpirationAt($event->expirationAt);

        foreach ($event->codes as $code)
        {
            $securityCode = new SecurityCode();
            $securityCode->setUuid(Uuid::uuid4());
            $securityCode->setEvent($event->uuid);
            $securityCode->setCode(Code::fromString($code));
            $securityCode->setStatus($event->status);
            $securityCode->setUsedAt($event->usedAt);
            $security->addSecurityCode($securityCode);
        }
    }

    public function securityCodeUsed(SecurityCodeUsed $event, SecurityCode $entity): void
    {
        $entity->setStatus($event->status);
        $entity->setUsedAt($event->usedAt);
    }

    public function securityCodeInvalidated(SecurityInvalidateCodes $event, Security $entity): void
    {
        $securityCodes = $entity->getSecurityCodes();
        $entity->setInvalidateAt($event->invalidateAt);

        foreach ($securityCodes as $securityCode)
        {
           $securityCode->setStatus(Status::fromString('used'));
           $securityCode->setUsedAt($event->invalidateAt);
        }
    }
}
