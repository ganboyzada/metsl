<?php

namespace App\Http\Controllers;


use App\Http\Requests\GroupRequest;

use App\Http\Requests\TaskRequest;

use App\Services\GroupService;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class TaskController extends Controller
{
    public function __construct(

        protected TaskService $taskService,

        )
    {
    }


    public function store(TaskRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['created_date'] = date('Y-m-d');

                $all_data['project_id'] = Session::get('projectID');
                $all_data['status'] = 1;

                $model = $this->taskService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function all(Request $request){
        $id = Session::get('projectID');
        $tasks = $this->taskService->allTasks($id);
 
     
        return $tasks;
    }


        public function all_assigned(Request $request){
        $id = Session::get('projectID');
        $tasks = $this->taskService->allTasksAssigned($id);

        $tasks->setCollection(
        $tasks->getCollection()->map(function ($task) {
            $end = Carbon::parse($task->end_date);
            $start = Carbon::parse($task->start_date);
            $diff = $start->diffInDays($end);
                $task->file_url = $task->file != NULL ? Storage::url('/project'.$task->project_id.'/tasks/'.$task->file) : NULL;
                $task->file_name = $task->file ?? NULL;
                $task->duration=$diff;
                return $task;

        })
    );
   
     
        return response()->json($tasks);
    }

    public function update(TaskRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                //$all_data['created_by'] = \Auth::user()->id;

                //$all_data['project_id'] = Session::get('projectID');

                $model = $this->taskService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }




    public function destroy($id){
        $this->taskService->delete($id);
        
    }

    public function change_status($id , $st){
        \App\Models\Task::where('id' , $id)->update(['done' => $st]);
    }


}