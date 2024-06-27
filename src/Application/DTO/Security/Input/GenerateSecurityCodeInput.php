<?php
declare(strict_types=1);
namespace App\Application\DTO\Security\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * This class represents input data for generating security code.
 * It includes validation constraints to ensure the input data is valid and matches expected values for generating security code.
 *
 * Attributes:
 * - `purpose`: The purpose for which security code is generated, like "2FA", "email_verification", "password_reset", "account_activation", or "transaction_approval".
 * - `codeLength`: The desired length of security code. Validated to ensure it's within an acceptable range.
 * - `deliveryMethod`: The method of delivering the security code, such as "email", "sms", or "push_notification".
 * - `securityLevel`: The security level for the generated code, indicating its strength and complexity.
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that the required fields are not empty, including `purpose`, `codeLength`, `deliveryMethod`, and `securityLevel`.
 * - `@Assert\Choice`: Ensures that fields like `purpose`, `deliveryMethod`, and `securityLevel` have valid values from a defined list.
 * - `@Assert\Range`: Ensures `codeLength` is within the valid range (minimum of 6 and maximum of 12 characters).
 *
 * Notes:
 * - The validation constraints are designed to ensure a proper data format and enforce business rules for security code generation.
 */
final class GenerateSecurityCodeInput
{
    /**
     * Purpose of the security code generation.
     * Determines the context and type of operation requiring the code.
     *
     * @Assert\NotBlank(message="Purpose is required.")
     * @Assert\Choice(
    choices={"2FA", "email_verification", "password_reset", "account_activation", "transaction_approval"},
    message="Invalid code purpose."
    )
     */
    public string $purpose;

    /**
     * Desired length of the security code.
     *
     * @Assert\NotBlank(message="Code length is required.")
     * @Assert\Range(min=6, max=12, minMessage="Code length must be at least 6 characters.", maxMessage="Code length cannot exceed 12 characters.")
     */
    public int $codeLength;

    /**
     * Delivery method for the security code (email, SMS, push notification).
     * Determines how the code will be sent to user.
     *
     * @Assert\NotBlank(message="Delivery method is required.")
     * @Assert\Choice(
    choices={"email", "sms", "push_notification"},
    message="Invalid delivery method."
    )
     */
    public string $deliveryMethod;

    /**
     * Security level for the generated code.
     * Determines the strength and complexity of the code.
     *
     * @Assert\NotBlank(message="Security level is required.")
     * @Assert\Choice(
    choices={"low", "medium", "high", "ultra"},
    message="Invalid security level."
    )
     */
    public string $securityLevel;
}
