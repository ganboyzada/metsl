<?php

namespace App\Models;

use App\Enums\MeetingPlanStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class MeetingPlan extends Model
{
    protected function casts(): array
    {
        return [
            'status' => MeetingPlanStatusEnum::class
        ];
    }
    
    
    protected $fillable = ['number','name','location','link','planned_date','start_time','duration','timezone','purpose','created_by','project_id','status'];

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'meeting_plan_participants', 'meeting_id', 'user_id');
    }

    public function files(): hasMany
    {
        return $this->hasMany(MeetingPlanfiles::class, 'meeting_id');
    }

    public function notes(): hasMany
    {
        return $this->hasMany(MeetingPlanNotes::class, 'meeting_id');
    }

    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
