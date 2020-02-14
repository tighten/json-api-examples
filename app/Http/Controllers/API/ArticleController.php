<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\CacheKeys;
use App\Http\Controllers\Controller;
use App\Transformers\ArticleTransformer;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    public function index()
    {
        $cacheLength = 60;

        $articles = Cache::remember(CacheKeys::articleIndex(request()), $cacheLength, function () {
            return QueryBuilder::for(Article::class)
                ->allowedIncludes(['author', 'comments'])
                ->allowedSorts(['created_at', 'title'])
                ->paginate(5);
        });

        return fractal($articles, new ArticleTransformer)->withResourceName('articles')->respondJsonApi();
    }

    public function show($articleId)
    {
        $cacheLength = 60;

        $article = Cache::remember(CacheKeys::articleShow($articleId, request()), $cacheLength, function () use ($articleId) {
            return QueryBuilder::for(Article::class)
                ->allowedIncludes(['author', 'comments'])
                ->where('id', $articleId)
                ->first();
        });

        if (! $article) {
            abort(404); // @todo Check this ! check, and that abort(404) is the actually correct response
        }

        return fractal($article, new ArticleTransformer)->withResourceName('articles')->respond();
    }
}
