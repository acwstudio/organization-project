<?php

namespace App\Http\Resources\Api\Faculties;

use App\Http\Resources\Api\Organizations\OrganizationResource;
use App\Http\Resources\Concerns\IncludeRelatedEntitiesResourceTrait;
use App\Models\Faculty;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Faculty */
class FacultyResource extends JsonResource
{
    use IncludeRelatedEntitiesResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => Faculty::TYPE_RESOURCE,
            'attributes' => $this->getAttributes(),
            'relationships' => [
                'organization' => $this->sectionRelationships('faculties.organization', OrganizationResource::class)
            ]
        ];
    }

    /**
     * @return array
     */
    protected function relations(): array
    {
        return [
            OrganizationResource::class => $this->whenLoaded('organization'),
        ];
    }
}
