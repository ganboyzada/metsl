<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProjectDrawingsRepositoryInterface
{
    /**
    * @param array $data
    * @return bool
    */

    public function create_bulk_files($data): bool;


    /**
    * @param int $project_id 
    * @param \Request $request
    * @return Collection
    * 
    */
    public function searchDrawings($project_id , $request): Collection;

}