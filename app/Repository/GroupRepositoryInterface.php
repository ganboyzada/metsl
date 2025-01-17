<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface GroupRepositoryInterface
{
    /**
    * @param integer $project_id
    * @return Collection
    */

    public function all_groups($project_id): Collection;



}