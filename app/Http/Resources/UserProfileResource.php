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
        $name = explode('_', $this->name);
        $first_name = $name[0];
        $last_name = $name[1];
        $resource = [
            "id" => $this->id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "user_name" => $this->name,
            "image" => $this->profile_photo_path,
            "email" => $this->email,
            "address" => '',
            "mobile_phone" => $this->mobile_phone,
            "office_phone" => '',
            "status" => 1
        ];
      
        $resource['user_type'] = 'user';      
        if(isset($this->access_token)){
            $resource['access_token'] = $this->access_token;
        }
        
        return $resource;
    }
}
