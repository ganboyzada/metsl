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

class DrawingResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "width" => $this->width,
            "height" => $this->height,
            "image" => $this->image,
            "url" => asset(Storage::url('project'.$this->project_id.'/drawings/'.$this->image))
            
        ];        
        return $resource;
    }
}
