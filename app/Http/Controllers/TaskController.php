<?php

namespace App\Http\Controllers;


use App\Http\Requests\GroupRequest;

use App\Services\GroupService;

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

        protected GroupService $groupService,

        )
    {
    }


    public function store(GroupRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['created_date'] = date('Y-m-d');

                $all_data['project_id'] = Session::get('projectID');
                $all_data['status'] = 1;

                $model = $this->groupService->create($all_data);
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
        $groups = $this->groupService->allGroups($id);
 
     
        return $groups;
    }

    public function update(GroupRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                //$all_data['created_by'] = \Auth::user()->id;

                //$all_data['project_id'] = Session::get('projectID');

                $model = $this->groupService->update($all_data);
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
        $group = $this->groupService->find($id);
        $group->tasks()->delete();
        $this->groupService->delete($id);
        
    }


}