<?php   

namespace App\Repository\Eloquent;   

use App\Repository\EloquentRepositoryInterface; 
use Illuminate\Database\Eloquent\Model;   
use Illuminate\Support\Collection;

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
        return $this->model->with($this->with)->get();
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
 
       /**
    * @param array $attributes
    *@param integer $id
    * @return Model
    */
    public function update(array $attributes , $id): Model
    {
        return $this->model->create($attributes , $id);
    }
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->with($this->with)->find($id);
    }

     
    public function delete($id)
    {
        return $this->model->delete($id);
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