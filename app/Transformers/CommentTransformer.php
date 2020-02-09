<?php

namespace App\Transformers;

use App\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
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
        'article',
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'body' => $comment->body,
        ];
    }

    public function includeAuthor(Comment $comment)
    {
        return $this->item($comment->author, new AuthorTransformer);
    }

    public function includeArticle(Comment $comment)
    {
        return $this->item($comment->article, new ArticleTransformer);
    }
}
