<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Channel::truncate();


        $channels = [
            ['name' => 'The Daily Grind', 'description' => 'A podcast that delves into daily routines and work-life balance.'],
            ['name' => 'Tech Talks', 'description' => 'Exploring the latest in technology and innovation.'],
            ['name' => 'History Unveiled', 'description' => 'Uncovering the hidden stories behind historical events.'],
            ['name' => 'Mindful Moments', 'description' => 'Guided sessions to help you stay mindful and calm.'],
            ['name' => 'Healthy Habits', 'description' => 'Tips and advice on maintaining a healthy lifestyle.'],
            ['name' => 'Comedy Corner', 'description' => 'A light-hearted podcast featuring comedy sketches and jokes.'],
            ['name' => 'Science Simplified', 'description' => 'Making complex scientific concepts easy to understand.'],
            ['name' => 'Kids Stories', 'description' => 'Engaging stories for children of all ages.'],
            ['name' => 'Business Buzz', 'description' => 'Insights and trends from the world of business.'],
            ['name' => 'Cultural Conversations', 'description' => 'Discussions on various cultural topics and traditions.'],
            ['name' => 'Sports Spotlight', 'description' => 'Highlighting the biggest moments in sports.'],
            ['name' => 'Future Tech', 'description' => 'Exploring the technology that will shape our future.'],
        ];



        foreach ($channels as $channel) {
            \App\Models\Channel::create([
                'user_id'=> 1,
                'name' => $channel['name'],
                'description' => $channel['description'],
            ]);
        }
    }
}
