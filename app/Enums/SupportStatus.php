<?php

namespace App\Enums;

enum SupportStatus: string
{
    case A = "Open";
    case C = "Closed";
    case P = "Pending";

    public static function fromValue(string $value): string
    {
        foreach (self::cases() as $status) {
            if ($value === $status->name) {
                return $status->value;
            }
        }

        throw new \ValueError('Status not found: ' . $value);
    }
}