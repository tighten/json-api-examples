<?php

namespace App\Http\Resources;

use App\ParsesIncludes;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    use ParsesIncludes;

    public $allowedIncludes = [
        'author',
        'comments',
        'comments.author',
    ];

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => parent::toArray($request),
            $this->mergeWhen($this->requestedIncludes($request)->isNotEmpty(), [
                'included' => $this->included($request),
            ]),
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application/vnd.api+json');
    }

    public function included($request)
    {
        $includes = $this->requestedIncludes($request);

        if ($includes->isEmpty()) {
            return [];
        }

        $included = [];

        if ($includes->contains('author')) {
            // @todo all authors, not just one.
            $included[] = new User($this->author);
        }

        // @todo flat map comments across all

        // @todo flat map comment authors, AND de-duplicate against article authors
        return ['@todo'];
    }
}
