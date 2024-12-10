<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DocumentRepositoryInterface
{


        /**
    * @param array $data 
    * @param Model $document 
    * 
    */
    public function add_users_to_document($data , $document);  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_documents($project_id , $request): Collection;  
}