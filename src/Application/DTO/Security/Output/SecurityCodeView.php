<?php
declare(strict_types=1);
namespace App\Application\DTO\Security\Output;

use App\Infrastructure\Shared\Bridge\ApiPlatform\DataTransformer\AbstractView;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a view of security code data, extending AbstractView.
 *
 * Attributes:
 * - `code`: The security code string.
 * - `status`: The status of the security code.
 * - `usedAt`: Nullable string representing the timestamp when the security code was used.
 *
 * Annotations:
 * - `@Groups({"read"})`: Indicates that the attributes are available for serialization in read operations.
 */
final class SecurityCodeView extends AbstractView
{
    /**
     * @var string The security code string.
     * @Groups({"read"})
     */
    public string $code;

    /**
     * @var string The status of the security code.
     * @Groups({"read"})
     */
    public string $status;

    /**
     * @var string|null The timestamp when the security code was used, formatted as DateTimeInterface::ATOM.
     * @Groups({"read"})
     */
    public ?string $usedAt;

    /**
     * Creates a SecurityCodeView object from a SecurityCode entity.
     *
     * @param object $object The SecurityCode entity to transform.
     * @return SecurityCodeView The created SecurityCodeView object.
     */
    public static function create(object $object): self
    {
        $view = new self();
        $view->code = (string) $object->getCode();
        $view->status = (string) $object->getStatus();
        $view->usedAt = $object->getUsedAt()?->format(DateTimeInterface::ATOM);
        return $view;
    }
}
