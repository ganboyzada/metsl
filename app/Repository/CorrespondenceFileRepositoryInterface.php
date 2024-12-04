<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CorrespondenceFileRepositoryInterface
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
}