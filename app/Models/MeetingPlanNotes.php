<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MeetingPlanNotes extends Model
{
    protected $fillable = ['note','type','assign_user_id','deadline','meeting_id','created_by','created_date'];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(MeetingPlan::class , 'meeting_id');
    }
   
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class , 'assign_user_id');
    }

}
