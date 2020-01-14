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
            $this->mergeWhen($this->requestedIncludes($request)->isNotEmpty(), [
                'relationships' => $this->relationships($request),
            ]),
        ];
    }

    public function withResponse($request, $response)
    {
        // @todo consider making a JsonApiResponse that these all extend (or a trait) so we don't have to duplicate this?
        $response->header('Content-Type', 'application/vnd.api+json');
    }

    public function requestedIncludes($request)
    {
        if (! $request->input('include')) {
            return collect([]);
        }

        // @todo Validate includes list?

        return collect(explode(',', $request->input('include')));
    }

    protected function relationships($request)
    {
        // Current thinking: only put stuff in here if it's pointing to
        // data down in the included() section ("compound document")
        // ... if that's true, that means we don't send the author_id unless
        // you include author. is that bad?

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
        $return = [];

        $includes = $this->requestedIncludes($request);

        if ($includes->isNotEmpty()) {
            $included = [];

            if ($includes->contains('author')) {
                $included[] = new User($this->author);
            }

            if ($includes->contains('comments')) {
                $included = array_merge(
                    $included,
                    $this->comments->map(function ($comment) {
                        // @todo: Make sure we're figuring out how to handle
                        // things like the include on "comments.author"
                        return (new Comment($comment))->toArray(null);
                    })->toArray()
                );
            }

            $return['included'] = $included;
        }

        return $return;
    }

    // @todo add included.. but only based on the eager load
}
