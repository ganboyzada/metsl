<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
class CorrespondenceRealtedCorrespondences extends Pivot
{
        use PivotEventTrait;

    public function Correspondence()
    {
        return $this->belongsTo(Correspondence::class);
    }

    public function relatedCorrespondence()
    {
        return $this->belongsTo(Correspondence::class , 'related_id');
    }
}
