<?php

namespace App\Services;

enum PleskWebspaceStatusEnum: int
{
    case Active             = 0;
    case Suspended          = 4;
    case DisabledByAdmin    = 16;
    case DisabledByReseller = 256;

    public function label(): string
    {
        return match($this) {
            self::Active             => 'Active',
            self::Suspended          => 'Suspended',
            self::DisabledByAdmin    => 'Disabled by Admin',
            self::DisabledByReseller => 'Disabled by Reseller',
        };
    }

    public function isActive(): bool
    {
        return $this === self::Active;
    }

    public function color(): string
    {
        return match($this) {
            self::Active             => 'green',
            self::Suspended          => 'orange',
            self::DisabledByAdmin, self::DisabledByReseller => 'red',
        };
    }
}