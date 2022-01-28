<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'playlist_id' => $this->playlist_id,
            'title' => $this->title,
            'type' => $this->type,
            'content' => $this->content,
            'description' => $this->description,
            'shared' => $this->shared,
            'order' => $this->order,
            'thumb_url' => $this->thumb_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gcr_activity_visibility' => $this->playlist->project->organization->gcr_activity_visibility,
            'subjects' => SubjectResource::collection($this->subjects),
            'education_levels' => EducationLevelResource::collection($this->educationLevels),
            'author_tags' => AuthorTagResource::collection($this->authorTags),
        ];

        // Feature added after the fact for optimization
        if ($request->skipContent === "true") {
            return $data;
        }

        $data['h5p_content'] = $this->h5p_content;
        return $data;
    }
}
