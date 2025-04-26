<?php

namespace App\Models;

use App\Enums\PunchListPriorityEnum;
use App\Enums\PunchListStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PunchList extends Model
{
    protected function casts(): array
    {
        return [
            'status' => PunchListStatusEnum::class,
            'priority'=> PunchListPriorityEnum::class
        ];
    }
    protected $fillable = ['number','title','location','cost_impact','priority','responsible_id','description','created_by','closed_by','project_id','status','date_notified_at','date_resolved_at','due_date'];

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'punch_list_participants', 'punch_list_id', 'user_id');
    }

    public function files(): hasMany
    {
        return $this->hasMany(PunchListfiles::class, 'punch_list_id');
    }

    public function project(): belongsTo
    {
        return $this->belongsTo(Project::class);
    }
	public function responsible(): belongsTo
    {
        return $this->belongsTo(User::class , 'responsible_id');
    }
	public function createdByUser(): belongsTo
    {
        return $this->belongsTo(User::class , 'created_by');
    }
	public function closedByUser(): belongsTo
    {
        return $this->belongsTo(User::class , 'closed_by');
    }

    public function replies(): hasMany
    {

        return $this->hasMany(PunchlistReplies::class, 'punch_list_id');
    }

    public function documentFiles(): belongsToMany
    {
        return $this->belongsToMany(ProjectDocumentFiles::class, 'punch_list_linked_documents', 
        'punchList_id', 'file_id')
        ->withPivot('revision_id')
        ->using(PunchListLinkedDocuments::class);
    } 

    public function drawings(): belongsToMany
    {
        return $this->belongsToMany(ProjectDrawings::class, 'punch_list_drawings', 
        'punchList_id', 'drawing_id')
        ->using(PunchListDrawings::class);
    } 
}
