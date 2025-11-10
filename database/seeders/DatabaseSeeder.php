<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // main
            LaratrustSeeder::class,
            AdminSeeder::class,  
            LanguageSeeder::class, 
            KeywordSeeder::class, 
            SettingSeeder::class, 


            // optional
            // ChannelSeeder::class,
            ArticleSeeder::class,
            SliderSeeder::class,
            CategorySeeder::class,
            CountrySeeder::class, 

        ]);
    }
}
