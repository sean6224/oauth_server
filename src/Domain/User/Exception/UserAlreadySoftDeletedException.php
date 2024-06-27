<?php
declare(strict_types=1);
namespace App\Domain\User\Exception;

use RuntimeException;

/**
 * This exception is thrown when an attempt is made to soft-delete
 * a user that is already soft-deleted.
 */
class UserAlreadySoftDeletedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("User is already soft-deleted.");
    }
}
