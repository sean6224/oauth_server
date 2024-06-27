<?php
declare(strict_types=1);
namespace App\Domain\Security\Exception;

use InvalidArgumentException;

class SecurityCodeLimitException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalidate codes and only then can you generate new ones');
    }
}
