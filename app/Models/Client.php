<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['first_name', 'last_name','user_name','email','mobile_phone','office_phone','address','specialty','image'];

    /**
     *
     * @return collection
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
    /**
     *
     * @return collection
     */
    public function projects(): MorphToMany
    {
        return $this->morphToMany(Project::class, 'projectable');
    }

    /**
     *
     * @return collection
     */
    public function issues(): MorphToMany
    {
        return $this->morphToMany(Issue::class, 'issueable');
    }
}
