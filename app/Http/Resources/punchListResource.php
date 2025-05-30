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

class punchListResource extends JsonResource
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
            "project_id" => $this->project_id,
            "number " => $this->number,
            "title" => $this->title,
            "location" => $this->location,
            "description" => $this->description,
            "date_notified_at" => $this->date_notified_at,
            "date_resolved_at" => $this->date_resolved_at,
            "due_date" => $this->due_date,
            "pin_x" => $this->pin_x,
            "pin_y" => $this->pin_y,
            "status"=> $this->status->text(),
            "priority"=> $this->priority->text(),
            "responsible"=>$this->package?->name??'',
            "responsible_user" =>$this->when(
                $this->relationLoaded('responsible') ,
                function () {
                    return new UserProfileResource($this->responsible);
                }
            ),

            "distrbution_members" => $this->when(
                $this->relationLoaded('users') ,
                function () {
                    return new UserProfileCollection($this->users);
                }
            ),
            
        ];
        $resource['linked_documents'] = $this->whenLoaded('documentFiles', function () {
            return  LinkedDocumentsResource::collection($this->documentFiles);
        });
        $resource['drawing'] = $this->whenLoaded('drawing', function () {
            return new DrawingResource($this->drawing);
        });


        $resource['replies'] = $this->whenLoaded('replies', function () {
            return ReplyResource::collection($this->replies);
        });
      
        $resource['files'] = [];
        if($this->files->count() > 0){
            foreach($this->files as $file){
                $file_arr = [];
                $file_arr['file'] = $file->file;
                $file_arr['file_url'] = asset(Storage::url('project'.$this->project_id.'/punch_list'.$this->id.'/'.$file->file));
                $resource['files'][] = $file_arr;
            }
        }
        
        return $resource;
    }
}
