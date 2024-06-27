<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\SignUp;

use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\HashedPassword;
use App\Domain\User\ValueObject\Username;
use App\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Command for signing up a new user.
 * Implements CommandInterface to define the structure of a command.
 *
 * Constructor Parameters:
 * - `string $email`: The email address of the new user.
 * - `string $username`: The username of the new user.
 * - `String $plainPassword`: The plain text password of the new user.
 *
 * Properties:
 * - `UuidInterface $uuid`: A universally unique identifier for the command instance.
 * - `Credentials $credentials`: Encapsulates the user's email and hashed password.
 * - `Username $username`: The username value object.
 *
 * Methods:
 * - `__construct(string $email, string $username, string $plainPassword)`: Initializes the command with email, username, and plain password. Generates a UUID and constructs Credentials and Username value objects.
 * - `uuid()`: Returns the UUID of the command instance.
 * - `username()`: Returns the Username value object.
 * - `Credentials()`: Returns the Credentials value object containing email and hashed password.
 */
final class SignUpCommand implements CommandInterface
{
    private UuidInterface $uuid;
    private Credentials $credentials;
    private Username $username;

    public function __construct(string $email, string $username, string $plainPassword)
    {
        $this->uuid = Uuid::uuid4();
        $this->username = Username::fromString($username);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::encode($plainPassword));
    }
    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }
    public function username(): Username
    {
        return $this->username;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}
