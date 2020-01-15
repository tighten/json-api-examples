<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    public function index()
    {
        return new ArticleCollection(Article::paginate());
    }

    public function show(Article $article)
    {
        $article->load(['author', 'comments']); // @todo: handle comments.author as well!

        return new ArticleResource($article);
    }
}
