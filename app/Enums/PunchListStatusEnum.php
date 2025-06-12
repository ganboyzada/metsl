<?php

namespace App\Enums;

enum  PunchListStatusEnum: int
{
    case PENDING = 0;
    case REVIEW = 1;

    case CLOSED = 2;



    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function text(): string
    {
        return match($this) 
        {
            self::PENDING => 'Pending',
            self::CLOSED => 'Closed',
            self::REVIEW => 'Review',

        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::PENDING => '#374151',
            self::CLOSED => '#4ab342',
            self::REVIEW => '#ff5a5a'
        };
    }
}
