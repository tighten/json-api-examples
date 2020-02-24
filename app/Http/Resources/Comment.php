<?php

namespace App\Http\Resources;

use App\ParsesIncludes;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    use ParsesIncludes;

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
            $this->mergeWhen($this->requestedIncludes($request)->isNotEmpty(), [
                'relationships' => $this->relationships($request),
            ]),
        ];
    }

    public function relationships($request)
    {
        $return = [];

        $includes = $this->requestedIncludes($request);

        if ($includes->contains('author')) {
            $return[] = [
                'author' => [
                    'data' => [
                        'type' => 'users',
                        'id' => $this->author_id,
                    ],
                ],
            ];
        }

        return $return;
    }
}
