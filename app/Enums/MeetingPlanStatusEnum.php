<?php

namespace App\Enums;

enum  MeetingPlanStatusEnum: int
{
    case PLANNED = 3;

    case ONGOING = 0;

    case DONE = 1;

    case CANCELLED = 2;
    case MISSED = 4;

    public function text(): string
    {
        return match($this) 
        {
            self::ONGOING => 'Ongoing',
            self::DONE => 'Done',
            self::CANCELLED => 'Cancelled',
            self::PLANNED => 'planned',
            self::MISSED => 'missed',
        };
    }

    public function color(): string
    {
        return match($this) 
        {
            self::ONGOING => 'bg-gray-500',
            self::DONE => 'bg-green-500',
            self::CANCELLED => 'bg-red-500',
            self::PLANNED => 'bg-blue-500',
            self::MISSED => 'bg-yellow-500',
        };
    }
}
