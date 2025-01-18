<?php

namespace App\Http\Controllers;


use App\Http\Requests\GroupRequest;
use App\Http\Requests\MeetingPlaningRequest;
use App\Services\GroupService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use View;


class GroupController extends Controller
{
    public function __construct(

        protected GroupService $groupService,
        protected UserService $userService

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
        $assignees = $this->userService->getUsersOfProjectID($id , 'assign_task');
        
 
     
        return ['groups'=>$groups , 'assignees'=>$assignees];
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