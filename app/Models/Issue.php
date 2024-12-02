<?php

namespace App\Models;

use App\Enums\IssueStatusEnum;
use App\Enums\IssueStatusTextColorEnum;
use App\Enums\IssueStatusTextValueEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

class Issue extends Model
{
    protected $table = 'issues';
    protected $fillable = ['name', 'description','type','project_id','Deadline','status'];


    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Acessores ---------------------------- *
     * ----------------------------------------------------------------- *
     */

     public function getStatusAttribute()
     {
 
         return match ((string)$this->attributes['status']) {
            IssueStatusEnum::INPROGRESS_INT => [IssueStatusTextColorEnum::INPROGRESS , IssueStatusTextValueEnum::INPROGRESS],
            IssueStatusEnum::DONE_INT => [IssueStatusTextColorEnum::DONE , IssueStatusTextValueEnum::DONE],
            IssueStatusEnum::CANCELLED_INT => [IssueStatusTextColorEnum::CANCELLED , IssueStatusTextValueEnum::CANCELLED],
         };
     }
    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Relations ---------------------------- *
     * ----------------------------------------------------------------- *
     */
       /**
     *
     * @return collection
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
	
    
}
