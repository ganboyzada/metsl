<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use App\Enums\ProjectStatusTextColorEnum;
use App\Enums\ProjectStatusTextValueEnum;
use Hash;
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
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;



class Project extends Model
{
    use PivotEventTrait;
    use EagerLoadPivotTrait;
    protected $table = 'projects';
   // protected $with = ['contractors']; 

    protected $fillable = ['name', 'description','logo','start_date' ,'end_date','status'];

    public  static function boot(){
        parent::boot();
        static::pivotSynced(function ($model, $relationName, $changes) {
            
            if(count($changes['attached']) > 0){
                
                foreach($changes['attached'] as $stakholder_id){
                    $user = User::find($stakholder_id); 
                    $job_title = 'stakeholder';
                    if($user->userable_type == Client::class){
                        $job_title = 'Client';
                    }elseif($user->userable_type == Contractor::class){
                        $job_title = 'Contractor';

                    }elseif($user->userable_type == ProjectManager::class){
                        $job_title = 'ProjectManager';
                    
                    }elseif($user->userable_type == DesignTeam::class){
                        $job_title = 'DesignTeam';

                    }
                    if($user->send_email_before == 0){
                        $pass = str()->random(8);
                        $user->password = Hash::make($pass);
                        $user->save();
                    }else{
                        $pass = '';;
                    }
                    
                    //dd($user);
                    $project_name = $model->name;
                    $m = \Mail::to($user->email)->send(new StakholderEmail($project_name , $job_title , $user->email ,$pass )); 
                    $user->send_email_before = 1;
                        $user->save();
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

	public function clients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id')->where('userable_type','App\Models\Client');
    } 
		
	public function contractors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id')->where('userable_type','App\Models\Contractor');
    } 	
    
    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function correspondences(): HasMany
    {
        return $this->hasMany(Correspondence::class);
    } 


    public function designTeams(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id')->where('userable_type','App\Models\DesignTeam');
    } 

	public function projectMangers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id')->where('userable_type','App\Models\ProjectManager');
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
