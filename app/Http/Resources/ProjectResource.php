<?php

namespace App\Http\Resources;

use App\Http\Resources\UserProfileResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "logo" => $this->logo,
            "created_by" => $this->user?->name??null,

        ];

        $resource['project_members'] = $this->whenLoaded('stakholders', function () {
            return UserProfileResource::collection($this->stakholders);
        });

        $resource['open_issued'] = $this->whenLoaded('correspondences', function () {
            return correspondencesResource::collection($this->correspondences);
        });

        return $resource;
    }
}
