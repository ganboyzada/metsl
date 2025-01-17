<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskAssignees extends pivot
{
    public function task(): belongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
