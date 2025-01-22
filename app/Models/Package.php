<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Package extends Model
{
    protected $fillable = ['name' , 'public_accessible'];




    public function assignees(): belongsToMany
    {
		return $this->belongsToMany(User::class, 'package_assignees', 'package_id', 'user_id')
        ->using(PackageAssignees::class);

    } 
}
