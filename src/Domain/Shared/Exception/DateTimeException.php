<?php
declare(strict_types=1);
namespace App\Domain\Shared\Exception;

use Exception;

class DateTimeException extends Exception
{
    public function __construct(Exception $e)
    {
        parent::__construct('Datetime Malformed or not valid', 500, $e);
    }
}
