<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
class PackageAssignees extends Pivot
{
    public function package(): belongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
