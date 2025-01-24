<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CorrespondenceLinkedDocuments extends Pivot
{
    public function correspondence(): belongsTo
    {
        return $this->belongsTo(Correspondence::class);
    }

    public function file(): belongsTo
    {
        return $this->belongsTo(ProjectDocumentFiles::class);
    }

    public function revision(): belongsTo
    {
        return $this->belongsTo(ProjectDocumentRevisions::class);
    }
}
