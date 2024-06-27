<?php
declare(strict_types=1);
namespace App\Domain\User\ValueObject\Auth;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\HashedPassword;

final class Credentials
{
    public function __construct(
        public Email $email,
        public HashedPassword $password
    ) { }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): HashedPassword
    {
        return $this->password;
    }
}
