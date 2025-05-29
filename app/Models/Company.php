<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'specialty',
        'phone',
        'email',
        'address',
        'active',
    ];

    public function employees(){
        return $this->hasMany(User::class);
    }

    public  function packages(): BelongsToMany{
        return $this->belongsToMany(WorkPackages::class, 'company_work_packages', 'company_id', 'work_package_id');
    }
}
