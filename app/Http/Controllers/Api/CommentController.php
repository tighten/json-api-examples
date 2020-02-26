<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\CommentCollection;
use Spatie\QueryBuilder\QueryBuilder;

class CommentController extends Controller
{
    public function index()
    {
        $comments = QueryBuilder::for(Comment::class)
            ->allowedIncludes(['author', 'article'])
            ->paginate();

        return new CommentCollection($comments);
    }

    public function show($commentId)
    {
        $comment = QueryBuilder::for(Comment::class)
            ->allowedIncludes(['author', 'article'])
            ->findOrFail($commentId);

        return new CommentResource($comment);
    }
}
