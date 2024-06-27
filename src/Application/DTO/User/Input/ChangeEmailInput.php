<?php
declare(strict_types=1);
namespace App\Application\DTO\User\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class represents the input data required to change user's email address.
 * It includes validation constraints to ensure the input data is valid.
 *
 * Attributes:
 * - `userUuid`: A string representing the UUID of the user. It has `@Assert\Uuid` to ensure it's valid UUID and `@Assert\NotBlank` to ensure it's not empty.
 * - `email`: A string representing the new email address. It has `@Assert\Email` to ensure it's valid email format and `@Assert\NotBlank` to ensure it's not empty.
 *
 * Validation Constraints:
 * - `@Assert\Uuid`: Ensures that `userUuid` is valid UUID.
 * - `@Assert\NotBlank`: Ensures that `userUuid` and `email` are not empty.
 * - `@Assert\Email`: Ensures that `email` is in valid email format.
 */
final class ChangeEmailInput
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    public string $userUuid;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;
}
