<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sliders_list = [
            ['image' => 'website-assets/images/slider-1.jpg'],
            ['image' => 'website-assets/images/slider-2.jpg'],
            ['image' => 'website-assets/images/slider-3.jpg'],
        ];

        \App\Models\Slider::insert($sliders_list);
    }
}
