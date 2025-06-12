<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDocument extends Model
{
    protected $fillable = ['title','number','status', 'project_id','custom_input','created_by','created_date','package_id','subfolder_id'];

    public function package(): belongsTo
    {
        return $this->belongsTo(Package::class);
    }
    public function subfolder(): belongsTo
    {
        return $this->belongsTo(PackageSubFolders::class , 'subfolder_id');
    }	
	
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
	
	public function reviewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_document_reviewers', 'project_document_id', 'user_id');
    } 

    public function files(): HasMany
    {
        return $this->hasMany(ProjectDocumentFiles::class);
    }  
 
    public function revisions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_document_revisions', 'project_document_id', 'user_id');
    } 
	
	public function LastRevisionDate()
    {
        return $this->hasOne(ProjectDocumentRevisions::class,'project_document_id')->latestOfMany();
    } 

    public function user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }
}
