<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class PunchListDrawings extends Pivot
{
    public function punchList(): belongsTo
    {
        return $this->belongsTo(PunchList::class , 'punchList_id');
    }

    
    public function drawing(): belongsTo
    {
        return $this->belongsTo(ProjectDrawings::class , 'drawing_id');
    }

}
