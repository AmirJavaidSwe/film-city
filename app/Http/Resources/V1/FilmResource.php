<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\CommentsResource;

class FilmResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'rating' => $this->rating,
            'ticket_price' => $this->ticket_price,
            'country' => $this->country,
            'photo' => $this->photo,
            'photoSrc' => $this->photoSrc,
            'genre' => $this->genre,
            'comments' => CommentsResource::collection($this->comments),
        ];
    }
}
