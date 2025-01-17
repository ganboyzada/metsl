<?php

namespace App\Models;

use App\Enums\RevisionStatusEnum;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectDocumentRevisions extends Pivot
{
	protected $table = 'project_document_revisions';
    protected $fillable = ['title','upload_date','file','status', 'user_id','project_document_id','project_document_file_id'];

    protected function casts(): array
    {
        return [
            'status' => RevisionStatusEnum::class
        ];
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(ProjectDocument::class , 'project_document_id');
    }

    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            ProjectDocument::class,
            'id', // refers to id column on invoices table
            'id', // refers to id column on customers table
            'project_document_id', // refers to invoice_id column on credit_notes table
            'project_id' // refers to customer_id column on invoices table
        );
    }
	


 
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	public function comments()
    {
        return $this->hasMany(ProjectDocumentRevisionComments::class , 'revision_id');
    }
}
