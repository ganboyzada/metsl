<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;


class Group extends Model
{
    protected $fillable = ['name','created_date','created_by','color','status','project_id'];

    public function tasks(): hasMany
    {
        return $this->hasMany(Task::class);
    }

}
