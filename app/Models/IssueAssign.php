<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class IssueAssign extends Model
{
    protected $table = 'issues';
    protected $fillable = ['issue_id', 'project_id'];

    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Relations ---------------------------- *
     * ----------------------------------------------------------------- *
     */
    /**
     *
     * @return collection
     */
    public function issueable(): MorphTo
    {
        return $this->morphTo();
    }
	
    
}
