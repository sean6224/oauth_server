<?php
declare(strict_types=1);
namespace App\Application\Message\Query\User\FindByUuid;

use App\Infrastructure\Shared\Bus\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

/**
 * This class represents query to find user by their UUID.
 * It implements the `QueryInterface` and encapsulates `UuidInterface` to represent user's UUID.
 *
 * Constructor Parameters:
 * - `string $userUuid`: A string representing the UUID of user to find. It is converted to `UuidInterface`.
 *
 * Methods:
 * - `userUuid()`: Returns the `UuidInterface` for user's UUID.
 */
readonly class FindByUuidQuery implements QueryInterface
{
    private UuidInterface $userUuid;

    public function __construct(
        UuidInterface $userUuid
    ) {
        $this->userUuid = $userUuid;
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }
}
