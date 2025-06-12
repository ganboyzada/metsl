<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Package extends Model
{
    protected $fillable = ['name' , 'public_accessible','project_id'];




    public function assignees(): belongsToMany
    {
		return $this->belongsToMany(User::class, 'package_assignees', 'package_id', 'user_id')
        ->using(PackageAssignees::class);

    } 

    public function subFolders(): hasMany
    {
        return $this->hasMany(PackageSubFolders::class);
    }

    public function documents(): hasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }
}
