<?php

namespace App\Models;

use App\Mail\StakholderEmail;
use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

use App\Models\Role;

class ProjectUser extends Pivot
{
    use PivotEventTrait;
    protected $table = 'projects_users';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
