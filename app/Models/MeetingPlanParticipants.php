<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

class MeetingPlanParticipants extends Pivot
{
    use PivotEventTrait;
    protected $table = 'meeting_plan_participants';
    protected $fillable = ['user_id','meeting_id'];


    public function meeting(): BelongsTo
    {
        return $this->belongsTo(MeetingPlan::class , 'meeting_id');
    }
   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
