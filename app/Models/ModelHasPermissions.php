<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Permission;

class ModelHasPermissions extends Pivot
{
    protected $table = 'model_has_permissions';

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'role_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
