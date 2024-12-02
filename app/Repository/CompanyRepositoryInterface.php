<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}