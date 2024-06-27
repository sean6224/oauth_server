<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\CodeUsed;

use App\Application\Service\SecurityCodeService;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

/**
 * Handles the command for marking security code as used.
 * Implements CommandHandlerInterface to handle the command.
 *
 * Methods:
 * - `__construct(SecurityCodeService $codeService)`: Constructor to initialize the handler with security code service.
 * - `__invoke(CodeUsedCommand $command)`: Handles the command by using the security code service to mark code as used.
 */
final readonly class CodeUsedCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SecurityCodeService $codeService
    ) { }

    public function __invoke(CodeUsedCommand $command): void
    {
        $this->codeService->useCode(
            $command->userUuid(),
            $command->getCode(),
            $command->getPurpose()
        );
    }
}
