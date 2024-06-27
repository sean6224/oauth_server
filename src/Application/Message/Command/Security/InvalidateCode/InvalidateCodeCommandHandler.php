<?php
declare(strict_types=1);
namespace App\Application\Message\Command\Security\InvalidateCode;

use App\Application\Service\SecurityCodeService;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

/**
 * This class handles the command to invalidate security codes for user.
 * It implements the `CommandHandlerInterface` and uses the `SecurityCodeService` to perform the operation.
 *
 * Constructor Parameters:
 * - `SecurityCodeService $codeService`: The service used to invalidate security codes.
 *
 * Methods:
 * - `__invoke(InvalidateCodeCommand $command)`: Invokes the handler to invalidate all security codes for the specified user and purpose.
 */
final readonly class InvalidateCodeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SecurityCodeService $codeService
    ) { }

    public function __invoke(InvalidateCodeCommand $command): void
    {
        $this->codeService->invalidateAllCode(
            $command->userUuid(),
            $command->getPurpose()
        );
    }
}
