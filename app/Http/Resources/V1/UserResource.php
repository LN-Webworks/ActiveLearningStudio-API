<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\OrganizationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            // 'name' => $this->name,
            'email' => $this->email,
            'organization_name' => $this->organization_name,
            'organization_type' => $this->organization_type,
            'job_title' => $this->job_title,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'website' => $this->website,
            'subscribed' => $this->subscribed,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'default_organization' => new OrganizationResource($this->defaultOrganization),
            'organization_role' => $this->whenPivotLoaded('organization_user_roles', function () {
                return $this->pivot->role->display_name;
            }),
            'projects_count' => $this->when($this->projects_count, $this->projects_count),
            'teams_count' => $this->when($this->teams_count, $this->teams_count),
            'groups_count' => $this->when($this->groups_count, $this->groups_count)
        ];
    }
}
