<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Task extends Model
{
    protected $fillable = ['subject','created_date','created_by','status','description','priority','start_date','end_date','file','group_id','project_id'];

    public function group(): belongsTo
    {
        return $this->belongsTo(Group::class);
    }


    public function assignees(): belongsToMany
    {
		return $this->belongsToMany(User::class, 'task_assignees', 'task_id', 'user_id')
        ->using(TaskAssignees::class);

    } 

}
