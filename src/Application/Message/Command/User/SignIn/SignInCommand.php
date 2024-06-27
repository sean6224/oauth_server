<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\SignIn;

use App\Domain\User\ValueObject\Email;
use App\Infrastructure\Shared\Bus\Command\CommandInterface;

/**
 * This class represents command to sign in user.
 * It implements the `CommandInterface` and encapsulates the email and password required to authenticate user.
 *
 * Attributes:
 * - `email`: The user's email address, represented by an `Email` value object.
 * - `plainPassword`: The user's password in plain text, used for authentication.
 *
 * Constructor:
 * - `__construct(string $email, string $plainPassword)`: Initializes the command with the provided email and plain password.
 *   Converts the email string into an `Email` value object.
 *
 * Methods:
 * - `email()`: Returns the `Email` value object representing the user's email.
 * - `plainPassword()`: Returns the plain text password used for sign-in.
 *
 * Notes:
 * - This command can be used with command bus or other similar architecture to initiate user authentication.
 * - The `plainPassword` is stored in plain text within this command; appropriate measures should be taken to secure this information.
 */
final class SignInCommand implements CommandInterface
{
    private Email $email;
    private string $plainPassword;

    public function __construct(string $email, string $plainPassword)
    {
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
