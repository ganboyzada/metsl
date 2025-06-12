<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


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
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_documents_assigned($project_id , $request): LengthAwarePaginator;
/**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_documents_packages($project_id , $request): Collection; 

    /**
    * @param int $id
    * @param \Request $request
    * @return Model
    * 
    */
    public function get_package($id, $request) :Model;

      /**
    * @param int $id
    * @param \Request $request
    * @return Model
    * 
    */
    public function get_sub_folder($id , $request): Model;
            /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    
    public function get_all_project_documents($project_id , $request): Collection;  

        /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}