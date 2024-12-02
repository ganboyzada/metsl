<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Permission extends SpatiePermission
{
    use EagerLoadPivotTrait;
    //
}
