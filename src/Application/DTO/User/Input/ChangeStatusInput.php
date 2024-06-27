<?php
declare(strict_types=1);
namespace App\Application\DTO\User\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class represents the input data required to change user's status.
 * It includes validation constraints to ensure the input data is valid and has appropriate values.
 *
 * Attributes:
 * - `securityCode`: A string representing security code for user status change. It has `@Assert\NotBlank` to ensure it's not empty and `@Assert\Type("string")` to ensure it's string.
 * - `status`: A string representing the new status for the user. It has `@Assert\NotBlank`, `@Assert\Type("string")`, and `@Assert\Choice(choices={"active", "suspended", "to be deleted"})` to ensure it is one of the valid status choices.
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that `securityCode` and `status` are not empty.
 * - `@Assert\Type("string")`: Ensures that both `securityCode` and `status` are strings.
 * - `@Assert\Choice(choices={"active", "suspended", "to be deleted"})`: Ensures that `status` is one of the allowed values, providing validation message for invalid choices.
*/
final class ChangeStatusInput
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $securityCode;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Choice(choices={"active", "suspended", "to be deleted"}, message="Status must be one of 'active', 'suspended', or 'to be deleted'")
     */
    public string $status;
}
