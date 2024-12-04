<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CorrespondenceDistributionMembers extends Pivot
{
    protected $table='correspondence_distribution_members';
    
    public function correspondence(): belongsTo
    {
        return $this->belongsTo(Correspondence::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
