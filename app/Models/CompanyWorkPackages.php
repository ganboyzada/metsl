<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use GeneaLabs\LaravelPivotEvents\Traits\PivotEventTrait;

class CompanyWorkPackages extends Pivot
{
    use PivotEventTrait;
    protected $table = 'company_work_packages';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(WorkPackages::class , 'work_package_id');
    }

}
