<?php
declare(strict_types=1);
namespace App\Application\DTO\Oauth\Input;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Input data required to create a new OAuth2 client.
 *
 * Attributes:
 * - `clientName`: A string representing the name of the client. It has `@Assert\NotBlank` to ensure it's not empty.
 * - `redirectUris`: An array of strings representing the redirect URIs allowed for the client. Each URI has `@Assert\Url` to ensure it's a valid URL format.
 * - `grants`: An array representing the grants (authorization types) allowed for the client. It has `@Assert\NotBlank` to ensure it's not empty.
 * - `scopes`: An array representing the scopes (access levels) allowed for the client. It has `@Assert\NotBlank` to ensure it's not empty.
 * - `active`: A boolean indicating whether the client is active. It has `@Assert\NotBlank` to ensure it's provided.
 * - `secret`: An optional string representing the client secret.
 *
 * Validation Constraints:
 * - `@Assert\NotBlank`: Ensures that `name`, `redirectUris`, `grants`, `scopes`, and `active` are not empty.
 * - `@Assert\Url`: Ensures that each URI in `redirectUris` is in valid URL format.
 */
final class CreateClientInput
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    public string $clientName;

    /**
     * @var array
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Url
     * })
     */
    public array $redirectUris;

    /**
     * @var array
     * @Assert\NotBlank
     */
    public array $grants;

    /**
     * @var array
     * @Assert\NotBlank
     */
    public array $scopes;

    /**
     * @var bool
     * @Assert\NotBlank
     */
    public bool $isActive;

    /**
     * @var string|null
     */
    public ?string $secret = null;
}
