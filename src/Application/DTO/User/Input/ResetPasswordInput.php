<?php
declare(strict_types=1);

namespace App\Application\DTO\User\Input;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * This class represents the input data required for resetting user's password.
 * It includes validation constraints to ensure that either email or security code field is provided.
 *
 * Attributes:
 * - `email`: A string representing the user's email address. It must not be blank if `codeSecurity` is blank.
 * - `codeSecurity`: A string representing the security code for resetting password. It must not be blank if `email` is blank.
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that at least one of `email` or `codeSecurity` is provided.
 */
class ResetPasswordInput
{
    /**
     * @Assert\Email(message="Invalid email address.")
     */
    public ?string $email = null;

    /**
     * @Assert\Type("string")
     */
    public ?string $codeSecurity = null;

    /**
     * @Assert\NotBlank(message="New password must not be blank.")
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Your password must be at least {{ limit }} characters long"
     * )
     */
    public string $newPassword;
}
