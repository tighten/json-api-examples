<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(3, true),
        'article_id' => factory(\App\Article::class),
        'author_id' => factory(\App\User::class),
    ];
});
