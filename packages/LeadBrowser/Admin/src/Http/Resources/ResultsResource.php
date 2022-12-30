<?php

namespace LeadBrowser\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'searchable_id' => $this->searchable_id,
            'organization_id' => $this->organization_id,
            'stage_id' => $this->stage_id,
            'price' => $this->price . ' zł',
            'organization_icon' => "<img class='profile-pic' style='max-width:80px' src='" . $this->organization_icon . "'>",//$this->resource->organization_icon,
            'organization_title' => $this->organization_title,
            'organization_rating' => $this->organization_rating,
            'organization_types' => $this->organization_types,
            'organization_website' => $this->organization_website,
            'organization_phone' => $this->organization_phone,
            'attributes' => [
                'test' => 1
            ]
        ];
    }
}
