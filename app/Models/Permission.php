<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

class Permission extends SpatiePermission
{
    use PivotEventTrait;
    use EagerLoadPivotTrait;

    public function allusers() {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id','model_id')
            ->withPivot('project_id')
            ->using(ModelHasPermissions::class);
    }  
    //
}
