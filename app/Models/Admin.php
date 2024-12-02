<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = ['first_name', 'last_name','user_name','email'];

    /**
     *
     * @return collection
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
