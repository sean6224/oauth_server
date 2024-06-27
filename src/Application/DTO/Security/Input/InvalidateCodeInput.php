<?php
declare(strict_types=1);
namespace App\Application\DTO\Security\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class represents input data for Invalidating security code.
 * It includes validation constraints to ensure the input data is valid and matches expected values for Invalidating security code.
 *
 * Attributes:
 * - `purpose`: The purpose for which security code is generated, like "2FA", "email_verification", "password_reset", "account_activation", or "transaction_approval".
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that the required fields are not empty, including `purpose`.
 * - `@Assert\Choice`: Ensures that fields like `purpose` have valid values from a defined list.
 *
 * Notes:
 * - The validation constraints are designed to ensure a proper data format and enforce business rules for security code invalidating.
 */
final class InvalidateCodeInput
{
    /**
     * Purpose of the security code used.
     * Determines the context and type of operation requiring the code.
     *
     * @Assert\NotBlank(message="Purpose is required.")
     * @Assert\Choice(
    choices={"2FA", "email_verification", "password_reset", "account_activation", "transaction_approval"},
    message="Invalid code purpose."
    )
     */
    public string $purpose;
}
