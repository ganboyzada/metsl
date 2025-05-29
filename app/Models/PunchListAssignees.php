<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
class PunchListAssignees extends pivot
{
    
        protected $fillable = ['user_id','punch_list_id'];


    public function punchList(): BelongsTo
    {
        return $this->belongsTo(PunchList::class , 'punch_list_id');
    }
   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
