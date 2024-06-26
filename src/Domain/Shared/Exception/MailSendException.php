<?php
declare(strict_types=1);
namespace App\Domain\Shared\Exception;

use RuntimeException;

/**
 * This exception is thrown when an operation is attempted on send mail
 */
class MailSendException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('An error occurred while sending an email.');
    }
}
