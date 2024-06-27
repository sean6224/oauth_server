<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ResetPassword;

use App\Infrastructure\Shared\Bus\Command\CommandInterface;

/**
 * Represents a command for resetting user password.
 * This command is used to reset user password using their email and security code.
 *
 * Properties:
 * - string $email: The email of user for whom to reset the password.
 * - string $code: The security code used for password reset verification.
 *
 * Methods:
 * - __construct (string $email, string $code): Constructor to initialize the command with email and code.
 *   - Parameters:
 *     - string $email: The email of user.
 *     - String $code: The security code for password reset verification.
 *
 * - getEmail(): string: Getter method to retrieve the email.
 *   - Returns:
 *     - string: The email of the user.
 *
 * - getCode(): string: Getter method to retrieve the security code.
 *   - Returns:
 *     - string: The security code for password reset verification.
 */
final readonly class ResetPasswordCommand implements CommandInterface
{
    public function __construct(
        private string $email,
        private string $code,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
