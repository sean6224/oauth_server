<?php
declare(strict_types=1);
namespace App\Application\DTO\User\Output;

use App\Domain\User\Entity\User;
use App\Infrastructure\Shared\Bridge\ApiPlatform\DataTransformer\AbstractView;
use Symfony\Component\Serializer\Annotation\Groups;
use Webmozart\Assert\Assert;

/**
 *  Represents a view of user information for a user.
 *
 * Attributes:
 * - `uuid`: The UUID of the User entity.
 * - `username`: The username of the User entity.
 * - `Email`: The email of the User entity.
 *
 * Annotations:
 * - `@Groups({"read"})`: Indicates that the attributes are available for serialization in read operations.
 */
final class UserView extends AbstractView
{
    /**
     * @var string The UUID of the User entity.
     * @Groups({"read"})
     */
    public string $uuid;

    /**
     * @var string The Username of the User entity.
     * @Groups({"read"})
     */
    public string $username;

    /**
     * @var string The Email of the User entity.
     * @Groups({"read"})
     */
    public string $email;

    /**
     * Creates a UserView object from a User entity.
     *
     * @param object $object The User entity to transform.
     * @return UserView The created UserView object.
     */
    public static function create(object $object): self
    {
        Assert::isInstanceOf($object, User::class);

        $view = new self();
        $view->uuid = (string) $object->getUuid();
        $view->username = (string) $object->getUsername();
        $view->email = (string) $object->getEmail();
        return $view;
    }
}
