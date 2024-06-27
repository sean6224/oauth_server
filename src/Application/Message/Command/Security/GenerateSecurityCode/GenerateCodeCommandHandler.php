<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\GenerateSecurityCode;

use App\Application\Service\SecurityCodeService;
use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Exception\DateTimeException;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

/**
 * Command handler for generating multiple security codes.
 *
 * Attributes:
 * - `codeService`: The service responsible for generating security codes.
 *
 * Methods:
 * - `__construct(SecurityCodeService $codeService)`: Constructor to initialize the command handler with security code service.
 * - `__invoke(GenerateCodeCommand $command)`: Handles the command to generate multiple security codes.
 *
 * Notes:
 * - This class handles the execution of the `GenerateCodeCommand` by invoking the security code service to generate codes.
 * - Exceptions `DateTimeException` and `BusinessRuleValidationException` may be thrown during the execution.
 */
final readonly class GenerateCodeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SecurityCodeService $codeService
    ) { }

    /**
     * @throws DateTimeException
     * @throws BusinessRuleValidationException
     */
    public function __invoke(GenerateCodeCommand $command): void
    {
        $this->codeService->multipleCode(
            $command->userUuid(),
            $command->getCodeLength(),
            $command->getSecurityLevel(),
            $command->getPurpose()
        );
    }
}
