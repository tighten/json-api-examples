<?php

use App\Article;
use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(3, true),
        'article_id' => factory(Article::class),
        'author_id' => factory(User::class),
    ];
});
