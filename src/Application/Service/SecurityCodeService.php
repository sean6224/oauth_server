<?php
declare(strict_types=1);
namespace App\Application\Service;

use App\Domain\Security\Entity\Manager\SecurityManager;
use App\Domain\Security\Exception\InvalidateCodeException;
use App\Domain\Security\Exception\SecurityCodeNoFoundException;
use App\Domain\Security\Repository\FindByCodeInterface;
use App\Domain\Security\Repository\FindNonInvalidatedByUserUuidInterface;
use App\Domain\Security\Repository\SecurityRepositoryInterface;
use App\Domain\Security\ValueObject\Purpose;
use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Exception\DateTimeException;
use App\Infrastructure\Shared\Service\CodeGeneratorService;
use Ramsey\Uuid\UuidInterface;

/**
 * This service class provides methods for managing security codes.
 *
 * Methods:
 * -
 * `__construct(SecurityCheckers $checkers,
 * SecurityRepositoryInterface $securityRepository, CodeGeneratorService $codeGenerator,
 * SecurityManager $securityManager, FindByCodeInterface $codeFinder,
 * FindNonInvalidatedByUserUuidInterface $nonInvalidatedCodeFinder)`:
 *   Initializes the service with dependencies.
 * - `multipleCode(UuidInterface $userUuid, int $codeLength, string $securityLevel, string $typeCode)`: Generates and saves multiple security codes for a user.
 * - `useCode(UuidInterface $userUuid, string $code, string $typeCode)`: Mark a security code as used.
 * - `invalidateAllCode(UuidInterface $userUuid, Purpose $purpose)`: Invalidates all security codes for a given user and purpose.
 *
 * Exceptions:
 * - `DateTimeException`: Thrown if there is an error related to date and time.
 * - `BusinessRuleValidationException`: Thrown if there is a validation error related to business rules.
 * - `SecurityCodeNoFoundException`: Thrown if a security code is not found.
 * - `InvalidateCodeException`: Thrown if there is an error invalidating security codes.
 */
readonly class SecurityCodeService
{
    public function __construct(
        private SecurityCheckers $checkers,
        private SecurityRepositoryInterface $securityCodeRepository,
        private CodeGeneratorService $codeGenerator,
        private SecurityManager $manager,
        private FindByCodeInterface $codeFinder,
        private FindNonInvalidatedByUserUuidInterface $nonInvalidatedCodeFinder,
    ) { }

    /**
     * @throws DateTimeException
     * @throws BusinessRuleValidationException
     */
    public function multipleCode(
        UuidInterface $userUuid,
        int $codeLength,
        string $securityLevel,
        string $typeCode
    ): void
    {
        $codesStrings = $this->codeGenerator->generateCode(5, $codeLength, $securityLevel);

        $createSecurityCode = $this->manager->saveCode(
            $userUuid,
            $codesStrings,
            $this->checkers->getCustomerSecurityChecker(),
            $typeCode
        );
        $this->securityCodeRepository->saveSecurity($createSecurityCode);
    }

    public function useCode(
        UuidInterface $userUuid,
        string $code,
        string $typeCode
    ): void
    {
        $securityCode = $this->codeFinder->findByCode($userUuid, $code);
        if ($securityCode === null) {
            throw new SecurityCodeNoFoundException();
        }

        $this->manager->markCodeAsUsed(
            $securityCode,
            $this->checkers->getCodeSecurityChecker(),
            $typeCode
        );
        $this->securityCodeRepository->saveSecurityCode($securityCode);
    }

    public function invalidateAllCode(
        UuidInterface $userUuid,
        Purpose $purpose
    ): void
    {
        $entity = $this->nonInvalidatedCodeFinder->findNonInvalidatedByUserUuid($userUuid, $purpose);

        if ($entity === null) {
            throw new InvalidateCodeException();
        }
        $this->manager->changeInvalidateCodes($entity);
        $this->securityCodeRepository->saveSecurity($entity);
    }
}
