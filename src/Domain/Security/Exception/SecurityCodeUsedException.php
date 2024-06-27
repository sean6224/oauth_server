<?php
declare(strict_types=1);
namespace App\Domain\Security\Exception;

use App\Domain\Shared\ValueObject\DateTime;
use InvalidArgumentException;

class SecurityCodeUsedException extends InvalidArgumentException
{
    public function __construct(DateTime $usedAt)
    {
        parent::__construct('The specified code has already been used on: ' . $usedAt->format('Y-m-d H:i:s'));
    }
}
