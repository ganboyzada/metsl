<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
class PackageSubFolders extends Model
{
        protected $fillable = ['name' , 'package_id'];




    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);

    } 
	
	public function documents(): hasMany
    {
        return $this->hasMany(ProjectDocument::class , 'subfolder_id');
    }
}
