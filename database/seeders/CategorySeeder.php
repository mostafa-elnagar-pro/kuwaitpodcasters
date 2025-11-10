<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['en' => 'Arts', 'ar' => 'الفن'],
            ['en' => 'Business', 'ar' => 'الأعمال'],
            ['en' => 'Comedy', 'ar' => 'الكوميديا'],
            ['en' => 'Education', 'ar' => 'التعليم'],
            ['en' => 'Health & Fitness', 'ar' => 'الصحة واللياقة البدنية'],
            ['en' => 'History', 'ar' => 'التاريخ'],
            ['en' => 'Kids & Family', 'ar' => 'الأطفال والعائلة'],
            ['en' => 'News', 'ar' => 'الأخبار'],
            ['en' => 'Science', 'ar' => 'العلم'],
            ['en' => 'Society & Culture', 'ar' => 'المجتمع والثقافة'],
            ['en' => 'Technology', 'ar' => 'التكنولوجيا'],
            ['en' => 'Sports', 'ar' => 'الرياضة'],
        ];


        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category
            ]);
        }
    }
    
}
