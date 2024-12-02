<?php
namespace App\Repository;

use App\Model\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{

    /**
    * @param integer $id 
    * @return Client
    */

    public function projects_of_client($id): Model;


    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}