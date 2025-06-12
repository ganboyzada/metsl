<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocumentRevisionComments extends Model
{
    protected $table = 'project_document_revision_comments';
    protected $fillable = ['revision_id','file_id','project_document_id','created_date','comment','type','image','status', 'user_id'];


    public function revision()
    {
        return $this->belongsTo(ProjectDocumentRevisions::class , 'revision_id');
    }

    public function file()
    {
        return $this->belongsTo(ProjectDocumentFiles::class , 'file_id');
    }
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
