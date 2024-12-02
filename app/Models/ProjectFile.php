<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFile extends Model
{
    protected $table= 'project_files';
    protected $fillable = ['name', 'project_id','type'];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
