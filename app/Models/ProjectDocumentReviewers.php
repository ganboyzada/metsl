<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

class ProjectDocumentReviewers extends Pivot
{
    use PivotEventTrait;
    protected $fillable = ['user_id','project_document_id','status'];


    public function ProjectDocument(): BelongsTo
    {
        return $this->belongsTo(ProjectDocument::class , 'project_document_id');
    }
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
