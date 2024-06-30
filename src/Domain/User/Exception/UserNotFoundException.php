<?php
declare(strict_types=1);
namespace App\Domain\User\Exception;

use RuntimeException;

/**
 * This exception is thrown when a user is not found.
 */
class UserNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Oops... User not found");
    }
}
