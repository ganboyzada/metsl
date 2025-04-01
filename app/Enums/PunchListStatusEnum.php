<?php

namespace App\Enums;

enum  PunchListStatusEnum: int
{
    case PENDING = 0;

    case REJECTED = 1;

    case ACCEPTED = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match($this) 
        {
            self::PENDING => 'Pending',
            self::REJECTED => 'Rejected',
            self::ACCEPTED => 'Accepted',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::PENDING => '#374151',
            self::REJECTED => '#ff5a5a',
            self::ACCEPTED => '#4ab342'
        };
    }
}
