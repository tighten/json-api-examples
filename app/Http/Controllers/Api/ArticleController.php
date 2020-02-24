<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedIncludes(['author', 'comments', 'comments.author'])
            ->allowedSorts(['created_at', 'title'])
            ->paginate();

        return new ArticleCollection($articles);
    }

    public function show($articleId)
    {
        $article = QueryBuilder::for(Article::class)
            ->allowedIncludes(['author', 'comments', 'comments.author'])
            ->allowedSorts(['created_at', 'title'])
            ->findOrFail($articleId);

        return new ArticleResource($article);
    }
}
