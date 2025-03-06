<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\Employee;
use App\Models\ProjectManager;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        if($request->validated()){
            $input = $request->all();
            $user = User::where(['email' => $input['email']])->with('userable')->first();

            if (isset($user) && $user->userable->status == 1) {
                if (Hash::check($input['password'], $user->password)) {
                    if($user->userable_type == DesignTeam::class){
                        $user->user_type = 'Design Team';
                    }
        
                    else if($user->userable_type == Contractor::class){
                        $user->user_type = 'Contractor';
                    }
        
                    else if($user->userable_type == Client::class){
                        $user->user_type = 'Client';
                    }

                    else if($user->userable_type == ProjectManager::class){
                        $user->user_type = 'Project Manager';
                    }
                    $user->access_token =  $user->createToken('metsl')->plainTextToken;
                    return $this->sendResponse([new UserProfileResource($user)], "You are successfully logged in");
                } else {
                    return $this->sendError("Password mismatch", [], 401);
                }
            } else if (isset($user)) {
                return $this->sendError("User not found or Account has been suspended.", [], 401);
            } else {
                return $this->sendError("User does not exist");
            }
        }

    }


    public function profile(){
        $user = User::where(['id' => auth()->user()->id])->with('userable')->first();
        return $this->sendResponse([new UserProfileResource($user)], "You are successfully logged in");
    }

	public function logout(Request $request){
		$request->user()->tokens()->delete();
 
		// Revoke the token that was used to authenticate the current request...
		$request->user()->currentAccessToken()->delete();
		return $this->sendResponse([], "You are successfully logged out");
	}
}
