<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return new \App\Http\Resources\ArticleCollection(\App\Article::paginate());
    }

    public function show(\App\Article $article)
    {
        $article->load(['author', 'comments', 'comments.author']); // @todo: handle comments.author as well!

        return new \App\Http\Resources\Article($article);
    }
}
