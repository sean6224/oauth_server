<?php
declare(strict_types=1);
namespace App\Domain\Security\Exception;

use InvalidArgumentException;

final class SecurityCodeNoFoundException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("The specified code does not exist");
    }
}
