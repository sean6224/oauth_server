<?php
declare(strict_types=1);
namespace App\Domain\User\Exception;

use RuntimeException;

/**
 * This exception is thrown when an attempt is made to restore a user
 * who is neither suspended nor soft-deleted.
 */
class UserCannotBeRestoredException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("User cannot be restored because they are neither suspended nor soft-deleted.");
    }
}
