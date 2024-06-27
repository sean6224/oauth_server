<?php
declare(strict_types=1);
namespace App\Domain\User\Exception;

use RuntimeException;

/**
 * This exception is thrown when an operation is attempted on a user
 * that is already suspended.
 */
class UserAlreadySuspendedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("User is already suspended.");
    }
}
