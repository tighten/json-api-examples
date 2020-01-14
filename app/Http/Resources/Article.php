<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
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
            'type' => 'articles',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'created_at' => $this->created_at->format('c'),
                'updated_at' => $this->created_at->format('c'),
            ],
            'relationships' => $this->relationships($request),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application/vnd.api+json');
    }

    protected function relationships($request)
    {
        // Current thinking: only put stuff in here if it's pointing to
        // data down in the included() section ("compound document")
        // ... if that's true, that means we don't send the author_id unless
        // you include author. is that bad?

        if (! $request->input('include')) {
            return [];
        }

        $return = [];
        $includes = collect(explode(',', $request->input('include')));

        // @todo Validate includes list?

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

        if ($includes->contains('comments')) {
            $return[] = [
                'comments' => [
                    'data' => $this->comments->map(function ($comment) {
                        return [
                            'type' => 'comments', // @todo do we store this on the Eloquent object as a const?
                            'id' => $comment->id,
                        ];
                    }),
                ],
            ];
        }

        return $return;
    }

    public function with($request)
    {
        if ($request->has('include')) {

        }

        return [

        ];
    }

    // @todo add included.. but only based on the eager load
}
