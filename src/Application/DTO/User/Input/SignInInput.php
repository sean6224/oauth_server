<?php
declare(strict_types=1);
namespace App\Application\DTO\User\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class represents the input data required for user sign-in operation.
 * It includes validation constraints to ensure the email and password are valid and not blank.
 *
 * Attributes:
 * - `email`: A string representing the user's email address. It has `@Assert\Email` to ensure it's valid email format and `@Assert\NotBlank` to ensure it's not empty.
 * - `password`: A string representing the user's password. It has `@Assert\NotBlank` to ensure it's not empty and `@Assert\Type("string")` to ensure it's a string.
 *
 * Validation Constraints:
 * - `@Assert\Email`: Ensures that `email` is in a valid email format.
 * - `@Assert\NotBlank`: Ensures that both `email` and `password` are not left empty.
 * - `@Assert\Type("string")`: Ensures that `password` is a string.
 *
 * Notes:
 * - This class is typically used as input for user sign-in operations API-based systems.
 * - The validation constraints are designed to ensure proper data format and prevent empty values for essential fields like email and password.
 */
final class SignInInput
{
    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $password;
}
