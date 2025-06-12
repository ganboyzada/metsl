<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

class CorrespondenceForwards extends Pivot
{
    public function correspondence()
    {
        return $this->belongsTo(Correspondence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
