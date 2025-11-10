<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [];

        for ($i = 1; $i <= 40; $i++) {
            $articles[] = [
                'image' => 'website-assets/images/artcle1.jpg',
                'title' => ['ar'=> 'Article Title $i'],
                'body' => ['ar'=> 'This is the body content for article $i. It provides information about web development, technology trends, and coding practices.']
            ];
        }


        foreach($articles  as $article){
            \App\Models\Article::create($article);
        }
    }
}
