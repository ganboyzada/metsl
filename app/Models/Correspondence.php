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

    protected $fillable = ['reply_correspondence_id','created_date','created_by','project_id','number', 'subject','type','status' ,'program_impact','cost_impact','description','recieved_from','recieved_date'];

    public function files(): HasMany
    {
        return $this->hasMany(CorrespondenceFile::class);
    }  
    
    public function assignees(): belongsToMany
    {
		return $this->belongsToMany(User::class, 'correspondence_assignees', 'correspondence_id', 'user_id')
        ->using(CorrespondenceAssignees::class);

    } 

    public function DistributionMembers(): belongsToMany
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

}
