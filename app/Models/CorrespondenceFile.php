<?php

namespace App\Models;

use App\Mail\StakholderEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Role;

class CorrespondenceFile extends Model
{
    protected $table = 'projects_users';


    public function correspondence(): BelongsTo
    {
        return $this->belongsTo(Correspondence::class);
    }

  
}