<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use App\Enums\ProjectStatusTextColorEnum;
use App\Enums\ProjectStatusTextValueEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Mail\StakholderEmail;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;


class Project extends Model
{
    use PivotEventTrait;
    protected $table = 'projects';
   // protected $with = ['contractors']; 

    protected $fillable = ['name', 'description','logo','start_date' ,'end_date','status'];

    public  static function boot(){
        parent::boot();
        static::pivotSynced(function ($model, $relationName, $changes) {
            if(count($changes['attached']) > 0){
                foreach($changes['attached'] as $stakholder_id){
                    $user = User::find($stakholder_id); 
                    $project_name = $model->name;
                    $m = \Mail::to($user->email)->send(new StakholderEmail($project_name)); 
                }
            }

        });    
    
        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
      
        });
        
        static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {

        });
    
        static::pivotDetached(function ($model, $relationName, $pivotIds) {

        });
 
       
    }
    

    protected function casts(): array
    {
        return [
            'status' => ProjectStatusEnum::class
        ];
    }

    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Acessores ---------------------------- *
     * ----------------------------------------------------------------- *
     */

    protected function getLogoAttribute(): string
    {
        if($this->attributes['logo'] != NULL){
            return Storage::url('project'.$this->attributes['id'].'/'.$this->attributes['logo']);
        }else{
            return asset('images/default100.png');
        }
        
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


    public function stakholders(): BelongsToMany
    {
         return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id');
    }     

    public function clients(): MorphToMany
    {
        return $this->morphedByMany(Client::class, 'projectable');
    }
 
    /**
     * Get all of the videos that are assigned this tag.
     */
	public function contractors(): MorphToMany
    {
        return $this->morphedByMany(Contractor::class, 'projectable');
    }

    public function designTeams(): MorphToMany
    {
        return $this->morphedByMany(DesignTeam::class, 'projectable');
    }
 
    /**
     * Get all of the videos that are assigned this tag.
     */
	public function projectMangers(): MorphToMany
    {
        return $this->morphedByMany(ProjectManager::class, 'projectable');
    }
	
	public function projectables(): HasMany
	{
		return $this->HasMany(Projectable::class, 'project_id');
	}
	
	 public function usersViaRole() {
        return $this->belongsToMany(User::class, 'model_has_roles', 'project_id','model_id')
            ->withPivot('role_id')
            ->using(ModelHasRoles::class);
    }
    public function usersViaPermission() {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'project_id','model_id')
            ->withPivot('permission_id')
            ->using(ModelHasPermissions::class);
    }   
}
