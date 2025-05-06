<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CorrespondenceRepositoryInterface
{

    /**
    * @param string $type 
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($type , $projectID): mixed;  
    
    
        /**
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_users_to_correspondence($data , $correspondence): void;  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_correspondence($project_id , $request): LengthAwarePaginator;  

/**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_correspondence_open($project_id , $request): LengthAwarePaginator;
        /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return Collection
    * 
    */
    public function get_correspondence_replies($project_id , $corespondence_id): Collection;


       /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return Collection
    * 
    */
    public function get_correspondence_parent($project_id , $corespondence_id): Collection;

     /**
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_Linked_documents_to_correspondence($data , $correspondence): void;
}