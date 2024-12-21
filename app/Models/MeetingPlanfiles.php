<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingPlanfiles extends Model
{
    protected $table = 'meeting_plan_files';
    protected $fillable = ['file','meeting_id','type','size'];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(MeetingPlan::class , 'meeting_id');
    }

    //
}
