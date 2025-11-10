<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = [
            // [
            //     "name" => "Egypt",
            //     "code" => "+20",
            //     "digits_count" => 10,
            //     "flag" => "eg",
            //     "created_at" => now()
            // ],
            // [
            //     "name" => "Saudi Arabia",
            //     "code" => "+966",
            //     "digits_count" => 9,
            //     "flag" => "sa",
            //     "created_at" => now()
            // ]
             [
                "name" => "Kuwait",
                "code" => "+965",
                "digits_count" => 8,
                "flag" => "kw",
                "created_at" => now()
            ]
            
        ];

        \App\Models\Country::insert($countries);
    }
}
