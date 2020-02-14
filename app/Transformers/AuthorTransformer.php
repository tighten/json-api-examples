<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
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
        'comments',
        'articles',
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
        ];
    }

    public function includeComments(User $user)
    {
        return $this->collection($user->comments, new CommentTransformer, 'comments');
    }

    public function includeArticles(User $user)
    {
        return $this->collection($user->articles, new ArticleTransformer, 'articles');
    }
}
