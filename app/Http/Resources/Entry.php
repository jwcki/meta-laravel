<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Entry extends JsonResource
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
            'imdbID' => $this->imdbID,
            'title' => $this->title,
            'year' => $this->year,
            'type' => $this->type,
            'poster' => !is_null($this->image) ? $this->image->url : null,
        ];
    }
}
