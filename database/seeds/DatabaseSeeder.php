<?php

use App\Article;
use App\Comment;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 25 users, each of which will write between 2 and 5 articles
        factory(User::class, 25)->create()->each(function ($author) {
            factory(Article::class, rand(2, 5))->create([
                'author_id' => $author->id,
            ]);
        });

        $authors = User::all();

        // For each article, add between 5 and 10 comments
        Article::all()->each(function ($article) use ($authors) {
            factory(Comment::class, rand(5, 10))->create([
                'article_id' => $article->id,
                'author_id' => $authors->random()->id,
            ]);
        });
    }
}
