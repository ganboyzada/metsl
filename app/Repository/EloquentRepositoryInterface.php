<?php
namespace App\Repository;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
  /**
    */
    public function all();

   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

      /**
    * @param array $attributes
    * @param int $id
    * @return Model
    */
    public function update(array $attributes , $id): Model;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;
   /**
    * @param $id
    * @return boolean
    */
    public function delete($id);
}