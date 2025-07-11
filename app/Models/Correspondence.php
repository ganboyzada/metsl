<?php

namespace App\Models;

use App\Enums\CorrespondenceCostImpactEnum;
use App\Enums\CorrespondenceProgrammImpactEnum;
use App\Enums\CorrespondenceStatusEnum;
use App\Enums\CorrespondenceTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Correspondence extends Model
{
    protected $table = 'correspondences';

    protected function casts(): array
    {
        return [
            'created_at' => 'date',
            //'status' => CorrespondenceStatusEnum::class,
            'type' => CorrespondenceTypeEnum::class,
            'cost_impact' => CorrespondenceCostImpactEnum::class,
            'program_impact' => CorrespondenceProgrammImpactEnum::class,


        ];
    }

    protected $fillable = ['reply_correspondence_id','reply_child_correspondence_id','due_days','due_date','changed_by','created_date','created_by','project_id','number', 'subject','type','status' ,'program_impact','cost_impact','description'];

    public function files(): HasMany
    {
        return $this->hasMany(CorrespondenceFile::class);
    }  
    
    public function assignees(): belongsToMany
    {
		return $this->belongsToMany(User::class, 'correspondence_assignees', 'correspondence_id', 'user_id')
        ->using(CorrespondenceAssignees::class);

    } 

    public function distributionMembers(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'correspondence_distribution_members', 'correspondence_id', 'user_id')
        ->using(CorrespondenceDistributionMembers::class);
    } 
    public function ReceivedFrom(): belongsTo
    {
        return $this->belongsTo(User::class, 'recieved_from', 'id');
    }

    public function CreatedBy(): belongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function ChangedBy(): belongsTo
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }

    public function documentFiles(): belongsToMany
    {
        return $this->belongsToMany(ProjectDocumentFiles::class, 'correspondence_linked_documents', 
        'correspondence_id', 'file_id')
        ->withPivot('revision_id')
        ->using(CorrespondenceLinkedDocuments::class);
    } 

    public function documentRevisions(): belongsToMany
    {
        return $this->belongsToMany(ProjectDocumentRevisions::class, 'correspondence_linked_documents', 
        'correspondence_id', 'revision_id')
        ->using(CorrespondenceLinkedDocuments::class);
    } 
    public function replies()
    {
        return $this->hasMany(Correspondence::class, 'reply_correspondence_id');
    }
    public function parent(): belongsTo
    {
        return $this->belongsTo(Correspondence::class, 'reply_correspondence_id', 'id');
    }

    public function replyon(): belongsTo
    {
        return $this->belongsTo(Correspondence::class, 'reply_child_correspondence_id', 'id');
    }

    public  function relatedCorrespondences(): BelongsToMany{
        return $this->belongsToMany(Correspondence::class, 'correspondence_related_correspondences', 'correspondence_id', 'related_id');
    }
	
	public  function forwards(): BelongsToMany{
        return $this->belongsToMany(User::class, 'correspondence_forwards', 'correspondence_id', 'user_id');
    }


}
