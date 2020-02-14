<?php

namespace App\Transformers;

use App\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'author',
        'comments',
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Article $article)
    {
        return [
            'id' => (int) $article->id,
            'title' => $article->title,
            'created_at' => $article->created_at->format('c'),
        ];
    }

    // @todo why is this not showing up in included?
    public function includeAuthor(Article $article)
    {
        return $this->item($article->author, new AuthorTransformer);
    }

    // @todo why are they not showing the right type?
    public function includeComments(Article $article)
    {
        return $this->collection($article->comments, new CommentTransformer);
    }
}
