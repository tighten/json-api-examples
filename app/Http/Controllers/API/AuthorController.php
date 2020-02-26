<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transformers\AuthorTransformer;
use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = QueryBuilder::for(User::class)
            ->allowedIncludes(['articles', 'comments'])
            ->allowedSorts(['created_at', 'name'])
            ->paginate(5);

        return fractal($authors, new AuthorTransformer)->respond();
    }
}
