<?php
declare(strict_types=1);
namespace App\Domain\User;

/**
 * This enum represents different types of operations that can be performed on user.
 * It defines set of possible values, providing predefined list of user operations.
 *
 * Enum Values:
 * - `SUSPEND`: Represents an operation to suspend user.
 * - `SOFT_DELETE`: Represents an operation to soft-delete a user (typically hides the user but does not permanently delete).
 * - `RESTORE`: Represents an operation to restore user from suspended or soft-deleted state.
 */
enum UserOperationType: string
{
    case SUSPEND = 'suspend';
    case SOFT_DELETE = 'soft_delete';
    case RESTORE = 'restore';
}
