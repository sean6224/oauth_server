<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Service;

use InvalidArgumentException;
use Symfony\Component\String\ByteString;

/**
 * This class is responsible for generating security codes with various security levels and optional duplicate characters.
 * It provides methods for generating random codes and ensures valid parameters for code generation.
 *
 * Methods:
 * - `generateCode(int $length, string $securityLevel = 'medium', bool $allowDuplicates = true)`: Generates security code with the specified length and security level.
 *    It allows or disallows duplicating characters based on the `allowDuplicates` parameter.
 * - `getCharacterSet(string $securityLevel)`: Returns a set of characters based on the specified security level.
 * - `validateParameters(int $length, string $characters, bool $allowDuplicates)`: Validates the input parameters for code generation, checking for valid length and character set.
 * - `generateUniqueCode(int $length, string $characters)`: Generates unique code without duplicate characters from the given character set.
 *
 * Notes:
 * - The `generateCode` method uses `ByteString::fromRandom` for generating random codes when duplicates are allowed.
 * - The `getCharacterSet` method returns character set based on the security level, with higher levels providing more complex characters.
 * - The `validateParameters` method checks for valid length and ensures that unique codes can be generated without exceeding the character set.
 * - If `allowDuplicates` is set to `false`, the `generateUniqueCode` method ensures unique characters in the generated code by shuffling and selecting from the character set.
 */
final class CodeGeneratorService
{
    public function generateCode(int $quantity, int $length, string $securityLevel = 'medium', bool $allowDuplicates = true): array
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be greater than zero.");
        }

        $characters = $this->getCharacterSet($securityLevel);
        $this->validateParameters($length, $characters, $allowDuplicates);

        $codes = [];

        for ($i = 0; $i < $quantity; $i++) {
            if (!$allowDuplicates) {
                $codes[] = $this->generateUniqueCode($length, $characters);
            } else {
                $codes[] = ByteString::fromRandom($length, $characters)->toString();
            }
        }

        return $codes;
    }

    private function getCharacterSet(string $securityLevel): string
    {
        return match ($securityLevel) {
            'low' => '0123456789',
            'medium' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'high' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
            'ultra' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()-_=+[]{}|;:,.<>?/',
            default => throw new InvalidArgumentException("Invalid security level: $securityLevel"),
        };
    }

    private function validateParameters(int $length, string $characters, bool $allowDuplicates): void
    {
        if ($length <= 0) {
            throw new InvalidArgumentException("Length must be greater than zero.");
        }

        if (!$allowDuplicates && $length > strlen($characters)) {
            throw new InvalidArgumentException("Cannot generate a unique code with specified length and character set.");
        }
    }

    private function generateUniqueCode(int $length, string $characters): string
    {
        $shuffled = str_split($characters);
        shuffle($shuffled);
        return implode('', array_slice($shuffled, 0, $length));
    }
}
