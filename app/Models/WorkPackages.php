<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkPackages extends Model
{
        protected $fillable = [
        'name'
    ];


    public function Companies(): BelongsToMany
    {
         return $this->belongsToMany(Company::class, 'company_work_packages', 'work_package_id', 'company_id');
    } 
}
