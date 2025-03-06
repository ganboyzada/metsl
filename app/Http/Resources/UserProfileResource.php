<?php

namespace App\Http\Resources;

use App\Http\Resources\InvoiceResource;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
	

    /**
     * Transform the resource into an array
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $resource = [
            "id" => $this->id,
            "first_name" => $this->userable->first_name,
            "last_name" => $this->userable->last_name,
            "user_name" => $this->userable->user_name,
            "image" => $this->userable->image,
            "email" => $this->userable->email,
            "address" => $this->userable->address,
            "mobile_phone" => $this->userable->mobile_phone,
            "office_phone" => $this->userable->office_phone,
            "status" => $this->userable->status
        ];
      
        if(isset($this->user_type)){
            $resource['user_type'] = $this->user_type;
        } else{
            if($this->userable_type == DesignTeam::class){
                $resource['user_type'] = 'Design Team';
            }

            else if($this->userable_type == Contractor::class){
                $resource['user_type'] = 'Contractor';
            }

            else if($this->userable_type == Client::class){
                $resource['user_type'] = 'Client';
            }

            else if($this->userable_type == ProjectManager::class){
                $resource['user_type'] = 'Project Manager';
            }
        }       
        if(isset($this->access_token)){
            $resource['access_token'] = $this->access_token;
        }
        
        return $resource;
    }
}
