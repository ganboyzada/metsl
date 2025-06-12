<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocumentFiles extends Model
{
    protected $table= 'project_document_files';
    protected $fillable = ['file', 'project_document_id ','type','size','status','preview_image'];  
	
    public function ProjectDocument(): BelongsTo
    {
        return $this->belongsTo(ProjectDocument::class);
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

    public function comments()
    {
        return $this->hasMany(ProjectDocumentRevisionComments::class , 'file_id');
    }
}
