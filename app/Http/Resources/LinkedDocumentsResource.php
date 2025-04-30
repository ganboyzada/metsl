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

class LinkedDocumentsResource extends JsonResource
{
	

    /**
     * Transform the resource into an array
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if($this->pivot->revision_id == NULL || $this->pivot->revision_id == 0){
            $url = asset(Storage::url('project'.$this->project->id.'/documents'.$this->project_document_id.'/'.$this->file));
        }else{
            $url = asset(Storage::url('project'.$this->project->id.'/documents'.$this->project_document_id.'/revisions/'.$this->file));
        }


        $resource = [
            "file" => $this->file,
            "url" => $url
            
        ];        
        return $resource;
    }
}
