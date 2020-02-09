<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return fractal(Article::all(), new ArticleTransformer)->respond();
    }
}
