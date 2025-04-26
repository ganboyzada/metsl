<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PunchListLinkedDocuments extends Pivot
{
    public function punchList(): belongsTo
    {
        return $this->belongsTo(PunchList::class,'punchList_id');
    }

    public function file(): belongsTo
    {
        return $this->belongsTo(ProjectDocumentFiles::class,'file_id');
    }

    public function revision(): belongsTo
    {
        return $this->belongsTo(ProjectDocumentRevisions::class);
    }
    //
}
