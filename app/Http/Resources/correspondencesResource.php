<?php

namespace App\Http\Resources;

use App\Http\Resources\InvoiceResource;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class correspondencesResource extends JsonResource
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
            "number " => $this->number,
            "subject" => $this->subject,
            "type" => $this->type,
            "status" => $this->status,
            "program_impact" => $this->program_impact,
            "cost_impact" => $this->cost_impact,
            "description" => $this->description,
            "created_date"=> $this->created_date,
        ];
      

        
        return $resource;
    }
}
