<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PunchListFiles extends Model
{
	protected $table = 'punch_list_files';
    protected $fillable = ['file','punch_list_id','type','size'];

    public function punchList(): BelongsTo
    {
        return $this->belongsTo(PunchList::class , 'punch_list_id');
    }
}
