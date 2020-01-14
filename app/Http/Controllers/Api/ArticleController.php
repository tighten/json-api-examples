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

    public function show(Article $article)
    {
        return new \App\Http\Resources\Article($article);
    }
}
