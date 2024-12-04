<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;

interface ProjectRepositoryInterface
{

    public function change_status($id , $status): bool;

   
      
}