<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Role;

class ModelHasRoles extends Pivot
{
    protected $table = 'model_has_roles';
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
