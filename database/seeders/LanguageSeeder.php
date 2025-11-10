<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        \App\Models\Language::create([
            'name'=> ['en'=> 'Arabic', 'ar'=> 'العربية'],
            'abbr'=> 'ar',
            'flag'=> 'sa',
            'direction'=> 'rtl',
            'is_active'=> true
        ]);

        \App\Models\Language::create([
            'name'=> ['en'=> 'English', 'ar'=> 'الانجليزية'],
            'abbr'=> 'en',
            'flag'=> 'us',
            'direction'=> 'ltr',
            'is_active'=> false
        ]);
    }
}
