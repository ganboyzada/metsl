<?php

namespace App\Enums;

enum  RevisionStatusEnum: int
{
    case PENDING = 0;

    case ACCEPTED= 1;

    case REJECTED = 2;


    public function text(): string
    {
        return match($this) 
        {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::PENDING => 'text-yellow-400',
            self::ACCEPTED => 'text-green-500',
            self::REJECTED => 'text-red-500',
        };
    }
	
    public function hover(): string
    {
        return match($this) 
        {
            self::PENDING => 'text-yellow-700',
            self::ACCEPTED => 'text-green-700',
            self::REJECTED => 'text-red-700',
        };
    }

    public function dataFeather(): string
    {
        return match($this) 
        {
            self::PENDING => 'stop-circle',
            self::ACCEPTED => 'check',
            self::REJECTED => 'x-circle',
        };
    }	
}
