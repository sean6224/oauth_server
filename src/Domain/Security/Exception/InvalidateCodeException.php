<?php
declare(strict_types=1);
namespace App\Domain\Security\Exception;

use InvalidArgumentException;

class InvalidateCodeException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("The codes are invalidated");
    }
}
