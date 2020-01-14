<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'type' => 'comments',
            'id' => $this->id,
            'attributes' => [
                'body' => $this->body,
                'created_at' => $this->created_at->format('c'),
                'updated_at' => $this->created_at->format('c'),
            ],
            // @todo relationships
        ];
    }
}
