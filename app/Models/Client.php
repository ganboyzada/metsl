<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['first_name', 'last_name','user_name','email','mobile_phone','office_phone','address','specialty','image', 'status'];

    protected function getimageAttribute(): string
    {
        if($this->attributes['image'] != NULL){
            return Storage::url('client'.$this->attributes['id'].'/'.$this->attributes['image']);
        }else{
            return asset('images/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.webp');
        }
        
    }

    /**
     *
     * @return collection
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'projects_users', 'user_id', 'project_id');
    } 


}
