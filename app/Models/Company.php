<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;


class Company extends Model
{
    protected $table = 'companies';
	// protected $with = ['projects'];

    protected $fillable = ['name', 'description','logo'];


    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Acessores ---------------------------- *
     * ----------------------------------------------------------------- *
     */

    protected function getLogoAttribute(): string
    {
        if($this->attributes['logo'] != NULL){
            return Storage::url('company'.$this->attributes['id'].'/'.$this->attributes['logo']);
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
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'company_id');
    }
    
}
