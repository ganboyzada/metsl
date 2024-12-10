<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocumentFiles extends Model
{
    protected $table= 'project_document_files';
    protected $fillable = ['file', 'project_document_id ','type','size'];  
	
    public function ProjectDocument(): BelongsTo
    {
        return $this->belongsTo(ProjectDocument::class);
    }
}
