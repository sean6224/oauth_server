<?php
declare(strict_types=1);
namespace App\Domain\Security\Exception;

use App\Domain\User\ValueObject\Security\Purpose;
use InvalidArgumentException;

class PurposeNoMatchException extends InvalidArgumentException
{
    public function __construct(Purpose $purpose, string $purposeType)
    {
        $message = sprintf(
            'The specified type code "%s" does not match the expected type code "%s".',
            $purposeType,
            $purpose->value()
        );
        parent::__construct($message);
    }
}
