<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\PlaylistProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyPlaylistResource extends JsonResource
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
            'title' => $this->title,
            'order' => $this->pivot->order,
            'project' => $this->project,
        ];
    }
}