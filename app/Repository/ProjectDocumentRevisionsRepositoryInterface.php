<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ProjectDocumentRevisionsRepositoryInterface
{
    /**
    * @param int $document_id
    * @return Collection
    */

    public function get_revisions_of_document($document_id): Collection;

    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;

        /**
    * @param array $data
    * @return bool
    */

    public function create_comment($data): bool;


       /**
    * @param int $id
    * @return Model
    */
    public function get_revision_comments($id) :Model;
}