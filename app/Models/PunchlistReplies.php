<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PunchlistReplies extends Model
{
    protected $fillable = ['title','description','file','punch_list_id','created_date','created_by'];

    public function punchList(): BelongsTo
    {
        return $this->belongsTo(PunchList::class , 'punch_list_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
