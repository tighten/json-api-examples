<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleCommentsController extends Controller
{
    public function index(Article $article)
    {
        $comments = QueryBuilder::for(Comment::class)
            ->where('article_id', $article->id)
            ->allowedIncludes(['author', 'article'])
            ->allowedSorts(['created_at'])
            ->paginate(5);

        return fractal($comments, new CommentTransformer)->respond();
    }
}
