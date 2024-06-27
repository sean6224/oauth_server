<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ResetPassword;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * This class represents the input data required for resetting user's password.
 * It includes validation constraints to ensure that both email and security code fields are not blank.
 *
 * Attributes:
 * - `email`: A string representing the user's email address. It must not be blank.
 * - `codeSecurity`: A string representing the security code for resetting password. It must not be blank.
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that both `email` and `codeSecurity` fields are not left empty.
 *
 * Callback:
 * - `validateAtLeastOneField()`: Ensures that at least one of the email or codeSecurity fields is provided.
 */
class ResetPasswordInput
{
    /**
     * @Assert\NotBlank
     */
    public ?string $email = 'null';

    /**
     * @Assert\NotBlank
     */
    public ?string $codeSecurity = 'null';

    /**
     * @Assert\Callback
     */
    public function validateAtLeastOneField(ExecutionContextInterface $context): void
    {
        if ($this->email === 'null' && $this->codeSecurity === 'null') {
            $context->buildViolation('Please provide an email address.')
                ->atPath('email')
                ->addViolation();
            $context->buildViolation('Please provide an security code.')
                ->atPath('codeSecurity')
                ->addViolation();
        }
    }
}
