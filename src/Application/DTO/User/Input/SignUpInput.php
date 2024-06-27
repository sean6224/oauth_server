<?php
declare(strict_types=1);
namespace App\Application\DTO\User\Input;

use Symfony\Component\Validator\Constraints as Assert;

final class SignUpInput
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    public string $username;

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
