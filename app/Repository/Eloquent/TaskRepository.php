<?php

namespace App\Repository\Eloquent;

use App\Models\Group;
use App\Models\Task;
use App\Repository\GroupRepositoryInterface;
use App\Repository\TaskRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;


class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Task $model
    */
   public function __construct(Task $model)
   {
       parent::__construct($model);
   }

  /**
    * @param integer $id
    * @return LengthAwarePaginator
    */
    public function all_tasks_assigned($project_id) :LengthAwarePaginator
    {
        $tasks =  $this->model->where('project_id',$project_id)->where('done',0)->with('assignees:id,name');
        if(auth()->user()->is_admin){
            $tasks = $tasks->paginate(5);
             return $tasks;
        }else{
             $tasks = $tasks->where(function($q){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });


                
            });

            $tasks=$tasks->paginate(5);
  
            return $tasks;

        }
    }

   /**
    * @param integer $id
    * @return Collection
    */
    public function all_tasks($project_id) :Collection
    {
        $tasks =  $this->model->where('project_id',$project_id)
        ->with('assignees:id,name');
        if(checkIfUserHasThisPermission($project_id , 'create_task_planner')){
            $tasks = $tasks->get()->map(function($task){
                $end = Carbon::parse($task->end_date);
                $start = Carbon::parse($task->start_date);

                $diff = $start->diffInDays($end);
                return [
                    'id' => $task->id,
                    'title' => $task->subject,
                    'groupId'=> $task->group_id,
                    'start'=> $task->start_date,
                    'end'=> $task->end_date,
                    'duration'=>$diff,
                    'assignees' => $task->assignees->pluck('name')->toArray(),
                    'priority' => $task->priority,
                    'attachments' => $task->file != NULL ?true : false,
                    'description' => $task->description,
                    'done' => $task->done,
                    'file_name' => $task->file,
                    'file' => $task->file != NULL ? Storage::url('/project'.$task->project_id.'/tasks/'.$task->file) : NULL
                ];
            });
            return $tasks;

        }        
        else if(!auth()->user()->is_admin){
            $tasks = $tasks->where(function($q){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                $q->orwhere('created_by', auth()->user()->id);


                
            });

            $tasks = $tasks->get()->map(function($task){
                $end = Carbon::parse($task->end_date);
                $start = Carbon::parse($task->start_date);

                $diff = $start->diffInDays($end);
                return [
                    'id' => $task->id,
                    'title' => $task->subject,
                    'groupId'=> $task->group_id,
                    'start'=> $task->start_date,
                    'end'=> $task->end_date,
                    'duration'=>$diff,
                    'assignees' => $task->assignees->pluck('name')->toArray(),
                    'priority' => $task->priority,
                    'attachments' => $task->file != NULL ?true : false,
                    'description' => $task->description,
                    'done' => $task->done,
                    'file_name' => $task->file,
                    'file' => $task->file != NULL ? Storage::url('/project'.$task->project_id.'/tasks/'.$task->file) : NULL
                ];
            });
            return $tasks;


        }
        
        
    }
 
        /**
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_users_to_task($data , $task): void
    {
        try{
            if(!$task){
                throw new \Exception('Record not find'); 
            }
            $task->assignees()->sync($data['assignees']);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
       // dd('ok');
    }
 
}