<?php

namespace App\Enums;

enum  PunchListPriorityEnum: string
{
    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    public function text(): string
    {
        return match($this) 
        {
            self::LOW => 'low',
            self::MEDIUM => 'medium',
            self::HIGH => 'high'
        };
    }
    public function color(): string
    {
        return match($this) 
        {
            self::LOW => '<div class="inline-flex items-center p-1 gap-1 bg-gray-500/25 rounded-full">
                        <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    </div>',
            self::MEDIUM => '<div class="inline-flex items-center p-1 gap-1 bg-yellow-500/25 rounded-full">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    </div>',
            self::HIGH => '<div class="inline-flex items-center p-1 gap-1 bg-red-500/25 rounded-full">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    </div>'
        };
    }
}
