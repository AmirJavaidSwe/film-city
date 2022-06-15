<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!$this->resource && !$this->resource->id) {
            return [];
        }
        return [
            'id' => $this->id,
            'comment_id' => $this->comment_id,
            'comment' => $this->comment,
            'user' => new UserResource($this->user),
            'childs' => CommentsResource::collection($this->childs)
        ];
    }
}
