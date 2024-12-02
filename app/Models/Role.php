<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Role extends SpatieRole
{
    use EagerLoadPivotTrait;
    //
}
