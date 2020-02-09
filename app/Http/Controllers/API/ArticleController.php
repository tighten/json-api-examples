<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedIncludes(['author', 'comments'])
            ->allowedSorts(['created_at', 'title'])
            ->paginate(5);

        return fractal($articles, new ArticleTransformer)->respond();
    }
}
