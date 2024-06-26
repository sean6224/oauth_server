<?php
declare(strict_types=1);
namespace App\Domain\Shared\Enum;

use MyCLabs\Enum\Enum;

/**
 * Represents an enumeration for email priority levels.
 * This enumeration defines three priority levels for emails: Low, Normal, and High.
 *
 * Methods:
 *  - getName(): string: Get the name of priority level.
 *  - getDescription(): string: Get the description of priority level.
 *
 * @method static EmailPriority LOW(): Method to get the low priority level.
 * @method static EmailPriority NORMAL(): Method to get the normal priority level.
 * @method static EmailPriority HIGH(): Method to get the high priority level.
 */
final class EmailPriority extends Enum
{
    private const LOW = 0;
    private const NORMAL = 1;
    private const HIGH = 2;

    public function getName(): string
    {
        return match ($this->value) {
            self::LOW => 'Low Priority',
            self::NORMAL => 'Normal Priority',
            self::HIGH => 'High Priority',
            default => 'Unknown Priority',
        };
    }

    public function getDescription(): string
    {
        return match ($this->value) {
            self::LOW => 'This is low priority e-mail.',
            self::NORMAL => 'This is normal priority e-mail.',
            self::HIGH => 'This is high priority e-mail.',
            default => 'Unknown priority e-mail.',
        };
    }
}
