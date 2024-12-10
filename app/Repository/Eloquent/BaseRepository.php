<?php   

namespace App\Repository\Eloquent;   

use App\Repository\EloquentRepositoryInterface; 
use Illuminate\Database\Eloquent\Model;   
use Illuminate\Support\Collection;
use  Illuminate\Database\Eloquent\Builder;

class BaseRepository implements EloquentRepositoryInterface
{     
    /**      
     * @var Model      
     */     
     protected $model;
     protected $with = [];       

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }
   /**
    *
    */
    public function all() {
       // $this->newQuery()->eagerLoadRelations();
       try{
            return $this->model->with($this->with)->get();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        try{
            return $this->model->create($attributes);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
    }
 
       /**
    * @param array $attributes
    *@param integer $id
    * @return bool
    */
    public function update(array $attributes , $id): bool
    {
        try{
            return $this->model->update($attributes , $id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
    }
    /**
    * @param $id
    * @return Model
    */
    public function find($id): Model
    {
        try{
           $model =  $this->model->with($this->with)->find($id);
           if(!$model){
                throw new \Exception('Record not find');
           }
           return $model;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
    }

     
    public function delete($id)
    {
        try{
            return $this->model->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function with($relations) {
        if (is_string($relations))
        {
            $this->with = explode(',', $relations);

            return $this;
        }

        $this->with = is_array($relations) ? $relations : [];

        return $this;
    }

    public function query()
    {
        return $this->model->newQuery()->with($this->with);
    }
}