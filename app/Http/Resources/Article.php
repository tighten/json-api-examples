<?php

namespace App\Http\Resources;

use App\ParsesIncludes;
use App\ReturnsJsonApi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    use ParsesIncludes, ReturnsJsonApi;

    public $allowedIncludes = [
        'author',
        'comments',
        'comments.author',
    ];

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
                'body' => $this->body,
                'created_at' => $this->created_at->format('c'),
                'updated_at' => $this->created_at->format('c'),
            ],
            $this->mergeWhen($this->requestedIncludes($request)->isNotEmpty(), [
                'relationships' => $this->relationships($request),
            ]),
        ];
    }

    protected function relationships($request)
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

        if ($includes->contains('comments')) {
            $return[] = [
                'comments' => [
                    'data' => $this->comments->map(function ($comment) use ($includes) {
                        return [
                            'type' => 'comments',
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
        $includes = $this->requestedIncludes($request);

        if ($includes->isEmpty()) {
            return [];
        }

        $included = [];

        if ($includes->contains('author')) {
            $included[] = new User($this->author);
        }

        // @todo: It looks like mergeWhen probably sets a key of 0,
        //        and then something later in the Laravel stack clears
        //        it out. We need to do that in these mapped usages of
        //        resources, sadly.

        // @todo: If we include comments.author, this needs a relationship section...
        // how do we pass a request that triggers it?
        if ($includes->contains('comments')) {
            $included = array_merge(
                $included,
                $this->comments->map(function ($comment) {
                    return (new Comment($comment))->toArray(new Request);
                })->toArray()
            );
        }

        if ($includes->contains('comments.author')) {
            $included = array_merge(
                $included,
                $this->comments->map(function ($comment) {
                    return (new User($comment->author))->toArray(new Request);
                })->toArray()
            );
        }

        return ['included' => $included];
    }
}
