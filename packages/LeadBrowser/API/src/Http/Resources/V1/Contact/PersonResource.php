<?php

namespace LeadBrowser\API\Http\Resources\V1\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'contact_numbers' => $this->contact_numbers,
            'social_media'    => $this->social_media,
            'organization'    => new OrganizationResource($this->organization),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
