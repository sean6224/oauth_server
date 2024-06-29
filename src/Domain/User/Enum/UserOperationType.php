<?php
declare(strict_types=1);
namespace App\Domain\User\Enum;

use MyCLabs\Enum\Enum;

/**
 * This enum represents different types of operations that can be performed on a user.
 * It defines a set of possible values, providing a predefined list of user operations.
 *
 * Enum Values:
 * - `SUSPEND`: Represents an operation to suspend a user.
 * - `SOFT_DELETE`: Represents an operation to soft-delete a user (typically hides the user but does not permanently delete).
 * - `RESTORE`: Represents an operation to restore a user from a suspended or soft-deleted state.
 */
final class UserOperationType extends Enum
{
    private const SUSPEND = 'suspend';
    private const SOFT_DELETE = 'soft_delete';
    private const RESTORE = 'restore';

    public static function suspend(): self
    {
        return new self(self::SUSPEND);
    }

    public static function softDelete(): self
    {
        return new self(self::SOFT_DELETE);
    }

    public static function restore(): self
    {
        return new self(self::RESTORE);
    }
}
