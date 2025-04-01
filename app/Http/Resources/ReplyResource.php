<?php

namespace App\Http\Resources;

use App\Http\Resources\InvoiceResource;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReplyResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,

            "file" => $this->file,
            "file_url" => asset(Storage::url('project'.$this->punchList->project_id.'/punch_list'.$this->punch_list_id .'/replies/'.$this->file)),
            "user" => $this->user->name,


            
        ];
      

        
        return $resource;
    }
}
