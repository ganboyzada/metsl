<?php
namespace App\Repository;

use App\Model\User;
use App\Model\Contractor;
use \Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Collection;

interface ContractorRepositoryInterface
{

    /**
    * @param integer $id    
    * @return Contractor
    */

    public function projects_of_contractor($id): Model;


    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}