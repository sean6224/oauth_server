<?php
declare(strict_types=1);
namespace App\Application\Message\Query\Security\DownloadCodePdf;

use App\Domain\User\ValueObject\Security\Purpose;
use App\Infrastructure\Shared\Bus\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents a query to download security code as PDF by UUID and purpose.
 * It implements the `QueryInterface` to be handled by a query bus.
 *
 * Constructor:
 * - `__construct(UuidInterface $uuid, string $purpose)`: Initializes the query with the given UUID and purpose.
 *
 * Methods:
 * - `getUuid()`: Returns the UUID associated with this query.
 * - `getPurpose()`: Returns the purpose associated with this query.
 *
 * Attributes:
 * - `uuid`: The UUID for which the security code is to be downloaded.
 * - `purpose`: The purpose for which the security code is to be downloaded.
 */
readonly class DownloadCodePdfQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public Purpose $purpose
    ) { }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getPurpose(): Purpose
    {
        return $this->purpose;
    }
}
