<?php
declare(strict_types=1);
namespace App\Application\DTO\Security\Output;

use App\Domain\Security\Entity\Security;
use App\Infrastructure\Shared\Bridge\ApiPlatform\DataTransformer\AbstractView;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Webmozart\Assert\Assert;

/**
 * Represents a view of security information for a user.
 *
 * Attributes:
 * - `uuid`: The UUID of the security entity.
 * - `purpose`: The purpose of the security entity.
 * - `createdAt`: The creation timestamp of the security entity.
 * - `expirationAt`: The expiration timestamp of the security entity.
 * - `invalidateAt`: Nullable timestamp indicating when the security entity was invalidated.
 * - `securityCodes`: Array of `SecurityCodeView` objects representing associated security codes.
 *
 * Annotations:
 * - `@Groups({"read"})`: Indicates that the attributes are available for serialization in read operations.
 */
final class SecurityView extends AbstractView
{
    /**
     * @var string The UUID of the security entity.
     * @Groups({"read"})
     */
    public string $uuid;

    /**
     * @var string The purpose of the security entity.
     * @Groups({"read"})
     */
    public string $purpose;

    /**
     * @var string The creation timestamp of the security entity in DateTimeInterface::ATOM format.
     * @Groups({"read"})
     */
    public string $createdAt;

    /**
     * @var string The expiration timestamp of the security entity in DateTimeInterface::ATOM format.
     * @Groups({"read"})
     */
    public string $expirationAt;

    /**
     * @var string|null The timestamp indicating when the security entity was invalidated in DateTimeInterface::ATOM format, or null if not invalidated.
     * @Groups({"read"})
     */
    public ?string $invalidateAt;

    /**
     * @var array Array of SecurityCodeView objects representing associated security codes.
     * @Groups({"read"})
     */
    public array $securityCodes;

    /**
     * Creates a SecurityView object from a Security entity.
     *
     * @param object $object The Security entity to transform into a view.
     * @return SecurityView The created SecurityView object.
     */
    public static function create(object $object): self
    {
        Assert::isInstanceOf($object, Security::class);

        $view = new self();
        $view->uuid = (string) $object->getUuid();
        $view->purpose = (string) $object->getPurposeType();
        $view->createdAt = $object->getCreatedAt()->format(DateTimeInterface::ATOM);
        $view->expirationAt = $object->getExpirationAt()->format(DateTimeInterface::ATOM);
        $view->invalidateAt = $object->getInvalidateAt() ? $object->getInvalidateAt()->format(DateTimeInterface::ATOM) : null;

        $view->securityCodes = [];
        foreach ($object->getSecurityCodes() as $securityCode) {
            $view->securityCodes[] = SecurityCodeView::create($securityCode);
        }

        return $view;
    }
}
