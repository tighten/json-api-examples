<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleCommentController extends Controller
{
    public function index($articleId)
    {
        $comments = QueryBuilder::for(Comment::class)
            ->where('article_id', $articleId)
            ->allowedIncludes(['author', 'article'])
            ->paginate();

        return new CommentCollection($comments);
    }
}
