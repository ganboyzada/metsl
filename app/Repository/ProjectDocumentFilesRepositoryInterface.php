<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProjectDocumentFilesRepositoryInterface
{
    /**
    * @param array $data
    * @return bool
    */

    public function create_bulk_files($data): bool;

    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;

    /**
    * @param integer $project_id
    * @return Collection
    */
    public function project_document_files($project_id): Collection;

     /**
    * @param integer $project_id
    */
    public function get_newest_files_by_project_document_id($project_id);
}